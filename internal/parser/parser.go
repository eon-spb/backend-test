package parser

import (
	"backend-test/internal/domain"
	"backend-test/pkg/parser"

	"github.com/sagikazarmark/slog-shim"
)

func Parse(path string, log *slog.Logger) []domain.Apartments {
	pars := parser.NewParser()

	apartments, err := pars.Parse(path, log)

	if err != nil {
		log.Debug("Error Parse: %s", err)
	}

	log.Debug("Complited get data from .xml")
	return apartments.Apartments
}
