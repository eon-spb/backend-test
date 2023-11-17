package app

import (
	"backend-test/internal/adapter"
	"backend-test/internal/config"
	"backend-test/internal/parser"
	"context"
	"os"
	"os/signal"
	"syscall"
	"time"

	"github.com/sagikazarmark/slog-shim"
)

var isFirstRun = true

func Setup(ctx context.Context, cfg *config.Db_config, logger *slog.Logger, adapter adapter.Adapter) {

	exitChan := make(chan os.Signal, 1)
	signal.Notify(exitChan, syscall.SIGINT, syscall.SIGTERM)

	// Канал для периодических задач
	ticker := time.NewTicker(1 * time.Minute)

	dump := parser.Parse(cfg.Application_cfg.Path_xml, logger)
	adapter.SaveApartments(ctx, dump, logger)

	logger.Debug("Daemon start")

	for {
		select {
		case <-exitChan:
			logger.Debug("Signal to stop daemon")
			ticker.Stop()
			return
		case <-ticker.C:
			logger.Debug("execution of the dressing task")
			dump = parser.Parse(cfg.Application_cfg.Path_xml, logger)
			adapter.SaveApartments(ctx, dump, logger)
		}
	}
}
