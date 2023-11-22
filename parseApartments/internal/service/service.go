package service

import (
	"context"
	"log"
	"sync"

	"github.com/BelyaevEI/backend-test/internal/config"
	"github.com/BelyaevEI/backend-test/internal/database"
	"github.com/BelyaevEI/backend-test/internal/logger"
	"github.com/BelyaevEI/backend-test/internal/parser"
	"github.com/BelyaevEI/backend-test/internal/utils"
)

type Service struct {
	Parser *parser.Parser
}

func New() (*Service, error) {

	log := logger.New()

	// Read config file
	cfg, err := config.LoadConfig(".")
	if err != nil {
		log.Log.Error("read config file is fail: ", err)
		return nil, err
	}

	// Connect to database
	db, err := database.NewConnect(cfg.DSN)
	if err != nil {
		log.Log.Error("failed connect to database :", err)
		return nil, err
	}

	// Create parser
	parser := parser.New(log, db, cfg.Filepath)

	return &Service{Parser: parser}, nil
}

func (service *Service) RunParser(ctx context.Context) {

	var wg sync.WaitGroup

	// Create chanel for graceful shutdown
	context, cancel, stop := utils.GracefulShutdown(ctx)

	// Create waitgroup
	wg.Add(1)

	go service.Parser.GoParse(context, &wg)

	// Wait signal for shutdown
	sig := <-stop
	log.Printf("Received signal: %v", sig)

	// Cancel context for finish active pocess
	cancel()

	// Wait finished all active process
	wg.Wait()

}
