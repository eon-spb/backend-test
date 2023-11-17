package postgres

import (
	"backend-test/internal/config"
	"context"
	"fmt"

	"github.com/jackc/pgx/v5"
	"github.com/jackc/pgx/v5/pgxpool"
	"github.com/sagikazarmark/slog-shim"
)

type Pg_Client interface {
	Query(ctx context.Context, sql string, args ...any) (pgx.Rows, error)

	QueryRow(ctx context.Context, sql string, args ...any) pgx.Row

	Begin(ctx context.Context) (pgx.Tx, error)
}

func New_Pg_client(cfg config.Db_config, logger *slog.Logger) (pool *pgxpool.Pool, err error) {
	ctx := context.Background()

	dsn := fmt.Sprintf("postgres://%s:%s@%s:%s/%s?sslmode=disable", cfg.Username, cfg.Password, cfg.Host, cfg.Port, cfg.Dbname)
	logger.Debug(dsn)
	pool, err = pgxpool.New(ctx, dsn)
	if err != nil {
		logger.Debug("Error when create postgresconn", err)

		return pool, err
	}

	return pool, err
}
