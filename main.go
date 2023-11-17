package main

import (
	"backend-test/app"
	"backend-test/internal/adapter"
	"backend-test/internal/config"
	"backend-test/internal/storage"
	"backend-test/pkg/postgres"
	"context"
	"os"

	"github.com/sagikazarmark/slog-shim"
)

func main() {

	opts := &slog.HandlerOptions{
		Level:     slog.LevelDebug,
		AddSource: true,
	}

	var (
		logger  = slog.New(slog.NewTextHandler(os.Stdout, opts))
		context = context.Background()
		config  = config.MustLoad()

		repository adapter.Adapter
	)

	client, err := postgres.New_Pg_client(*config, logger)

	if err != nil {
		panic(err)
	}

	repository = storage.NewRepository(client, logger)

	logger.Debug("Application start")

	app.Setup(context, config, logger, repository)
}
