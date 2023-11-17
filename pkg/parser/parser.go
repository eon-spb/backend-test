package parser

import (
	"backend-test/internal/domain"
	"encoding/xml"
	"io/ioutil"
	"os"

	"github.com/sagikazarmark/slog-shim"
)

type Parser struct {
}

type IParser interface {
	Parse(path string, logger *slog.Logger) (*domain.Data, error)
}

func NewParser() IParser {
	return &Parser{}
}

func (p *Parser) Parse(path string, logger *slog.Logger) (*domain.Data, error) {
	xmlData, err := os.Open(path)

	if err != nil {
		logger.Debug("Error %s", err)
		return nil, err
	}
	xmlFile, _ := ioutil.ReadAll(xmlData)

	defer xmlData.Close()

	var data domain.Data
	err = xml.Unmarshal([]byte(xmlFile), &data)
	if err != nil {
		logger.Debug("Error unmarshalling XML: %v\n", err)
		return nil, err

	}
	return &data, nil
}
