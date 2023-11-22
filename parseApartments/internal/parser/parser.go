package parser

import (
	"context"
	"encoding/xml"
	"errors"
	"io"
	"os"
	"sync"

	"github.com/BelyaevEI/backend-test/internal/database"
	"github.com/BelyaevEI/backend-test/internal/logger"
	"github.com/BelyaevEI/backend-test/internal/models"
)

type Parser struct {
	log      *logger.Logger
	db       *database.Database
	filepath string
}

func New(log *logger.Logger, db *database.Database, filepath string) *Parser {
	return &Parser{
		log:      log,
		db:       db,
		filepath: filepath,
	}
}

func (parser *Parser) GoParse(ctx context.Context, wg *sync.WaitGroup) {

	defer wg.Done()

	select {
	case <-ctx.Done():
		return
	default:

		// Finally parse xml
		parser.parseXML()

		// Close database
		parser.db.Close()
	}

	// relativePath := filepath.Join("storage", "tmp", "test.xml")

}

func (parser *Parser) parseXML() {

	// Open file for parse
	file, err := os.Open(parser.filepath)
	if err != nil {
		parser.log.Log.Errorln("open file is fail :", err)
		return
	}

	defer file.Close()

	decoder := xml.NewDecoder(file)

	// Parse file while find start element in file
	for {
		token, err := decoder.Token()
		if err != nil {

			// End of file and leave program
			if errors.Is(err, io.EOF) {
				break
			}

			parser.log.Log.Error("decode is fail: ", err)
			break
		}

		if token == nil {
			break
		}

		switch se := token.(type) {
		case xml.StartElement:

			// If start element "apartment" decode tag
			if se.Name.Local == "apartment" {

				var apart models.Apartment

				err := decoder.DecodeElement(&apart, &se)
				if err != nil {
					parser.log.Log.Errorln("decode element is fail: ", err)
					break
				}

				// Save apartment to database
				// goroutine?
				err = parser.db.SaveApartment(apart.ID, apart.STotal, apart.SLiving, apart.SKitchen, apart.Price, apart.Height, apart.Floor)
				if err != nil {
					parser.log.Log.Errorln("failed save in database: ", err)
					continue
				}
			}
		}
	}
}
