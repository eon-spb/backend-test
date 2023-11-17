package storage

import (
	"backend-test/internal/adapter"
	"backend-test/internal/domain"
	"backend-test/pkg/postgres"
	"context"
	"log/slog"
	"time"
)

type repository struct {
	pg_client postgres.Pg_Client
	log       *slog.Logger
}

func NewRepository(client postgres.Pg_Client, logger *slog.Logger) adapter.Adapter {
	return &repository{
		pg_client: client,
		log:       logger,
	}
}

func (r *repository) SaveApartments(ctx context.Context, apartments []domain.Apartments, logger *slog.Logger) error {
	ctx, cancel := context.WithTimeout(ctx, 5*time.Second)
	defer cancel()

	tx, err := r.pg_client.Begin(ctx)
	if err != nil {
		logger.Debug("Error %s", err)
		return err
	}
	defer tx.Rollback(ctx)

	// Execute the statement for each apartment
	for _, apt := range apartments {
		_, err := tx.Exec(ctx, "INSERT INTO apartments(s_total, s_living, s_kitchen, height, price, floor) VALUES($1, $2, $3, $4, $5, $6)",
			apt.STotal, apt.SLiving, apt.SKitchen, apt.Height, apt.Price, apt.Floor)
		if err != nil {
			logger.Debug("Error func SaveApartments with error: %s", err)
			return err
		}
	}

	// Commit the transaction
	err = tx.Commit(ctx)
	if err != nil {
		logger.Debug("Error commit transaction: %s", err)
		return err
	}

	return nil
}
