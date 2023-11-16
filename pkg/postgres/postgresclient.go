package postgres

import (
	"context"
	"os"

	"github.com/jackc/pgx/v5"
	"github.com/jackc/pgx/v5/pgxpool"
	"github.com/sagikazarmark/slog-shim"
)

type Pg_Client interface {
	Query(ctx context.Context, sql string, args ...any) (pgx.Rows, error)

	QueryRow(ctx context.Context, sql string, args ...any) pgx.Row
}

func New_Pg_client(logger *slog.Logger) (pool *pgxpool.Pool, err error) {
	ctx := context.Background()
	// dsn := create_dsn(config)
	dsn := os.Getenv("POSTGRESQL_URL")
	logger.Debug(dsn)
	pool, err = pgxpool.New(ctx, dsn)
	if err != nil {
		logger.Debug("Error when create postgresconn", err)

		return pool, err
	}

	return pool, err
}

// func create_dsn(config *config.Config) string {
// 	return fmt.Sprintf(
// 		"postgresql://%s:%s@%s:%s/%s", config.DataBase.DB_user, config.DataBase.DB_password,
// 		config.DataBase.DB_adress, config.DataBase.DB_port,
// 		config.DataBase.DB_name)

// }
