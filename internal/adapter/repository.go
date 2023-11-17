package adapter

import (
	"backend-test/internal/domain"
	"context"

	"github.com/sagikazarmark/slog-shim"
)

type Adapter interface {
	SaveApartments(ctx context.Context, data []domain.Apartments, logger *slog.Logger) error
}
