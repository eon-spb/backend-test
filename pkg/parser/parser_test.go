package parser

import (
	"backend-test/internal/domain"
	"log/slog"
	"testing"

	"github.com/stretchr/testify/assert"
)

func TestParser(t *testing.T) {
	expected := []domain.Apartments{
		{ID: "25901c82-7b6b-44f6-8fd2-437c0c697a57", STotal: "400.00", SLiving: "297.00", SKitchen: "126.00", Height: 0, Price: "755336060.00"},
		{ID: "f6c1a4ab-4b8c-438e-8aa4-97dd17697750", STotal: "454.00", SLiving: "127.00", SKitchen: "88.00", Height: 0, Price: "230186813.00", Floor: 10},
		{ID: "7b9cca01-1312-42b5-9912-c0e87aec4126", STotal: "45.00", SLiving: "303.00", SKitchen: "58.00", Height: 15, Price: "373080128.00"},
	}

	actual, err := NewParser().Parse("test.xml", slog.Default())

	if err != nil {
		panic(err)
	}

	assert.Equal(t, expected, actual.Apartments)
}
