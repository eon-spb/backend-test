package adapter

import "context"

type User_adapter interface {
	ParseXML(ctx context.Context) error
}
