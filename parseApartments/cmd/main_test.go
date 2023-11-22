package main

import (
	"context"
	"log"
	"testing"
	"time"

	"github.com/BelyaevEI/backend-test/internal/service"
	"github.com/stretchr/testify/require"
)

func TestMain(t *testing.T) {

	type test struct {
		name string
		want time.Duration
	}

	test1 := test{
		name: "Check work time",
		want: 30 * time.Minute,
	}

	// Context
	ctx := context.Background()

	// Create service for parsing xml file
	service, err := service.New()
	if err != nil {
		log.Fatal(err)
		return
	}

	t.Run(test1.name, func(t *testing.T) {

		// Start time app
		startTime := time.Now()

		// Parse file and save data in database
		service.RunParser(ctx)

		// Stop time app
		stopTime := time.Since(startTime)

		// Check time
		require.True(t, stopTime <= test1.want)

	})

}
