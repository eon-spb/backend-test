package app

import (
	"backend-test/internal/adapter"
	"backend-test/internal/config"
	"backend-test/internal/parser"
	"context"

	"github.com/sagikazarmark/slog-shim"
)

func Setup(ctx context.Context, cfg *config.Db_config, logger *slog.Logger, adapter adapter.Adapter) {
	dump := parser.Parse(cfg.Application_cfg.Path_xml, logger)

	adapter.SaveApartments(ctx, dump, logger)

}
