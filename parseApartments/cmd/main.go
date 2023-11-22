package main

import (
	"context"
	"log"

	"github.com/BelyaevEI/backend-test/internal/service"
)

func main() {

	// Context
	ctx := context.Background()

	// Create service for parsing xml file
	service, err := service.New()
	if err != nil {
		log.Fatal(err)
		return
	}

	// Parse file and save data in database
	service.RunParser(ctx)

}
