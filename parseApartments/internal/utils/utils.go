package utils

import (
	"context"
	"os"
	"os/signal"
	"syscall"
)

func GracefulShutdown(ctx context.Context) (context.Context, context.CancelFunc, chan os.Signal) {

	ctx, cancel := context.WithCancel(ctx)

	stop := make(chan os.Signal, 1)

	// Registred sygnal
	signal.Notify(stop, syscall.SIGTERM, syscall.SIGINT, syscall.SIGQUIT)

	return ctx, cancel, stop

}
