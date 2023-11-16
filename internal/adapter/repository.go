package adapter

import (
	"backend-test/internal/domain"
	"context"
)

type User_adapter interface {
	SaveApartments(ctx context.Context, data []domain.Apartments) error
}
