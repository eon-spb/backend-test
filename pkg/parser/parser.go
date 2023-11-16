package parser

import (
	"backend-test/internal/domain"
	"encoding/xml"
	"io/ioutil"
	"os"
)

type Parser struct {
}

type IParser interface {
	Parse(path string) (*domain.Data, error) //!!todo return *parse file

}

func NewParser() IParser {
	return &Parser{}
}

func (p *Parser) Parse(path string) (*domain.Data, error) {
	xmlData, err := os.Open(path)

	if err != nil {
		panic(err)
	}
	xmlFile, _ := ioutil.ReadAll(xmlData)

	defer xmlData.Close()

	var data domain.Data
	err = xml.Unmarshal([]byte(xmlFile), &data)
	if err != nil {
		// fmt.Printf("Error unmarshalling XML: %v\n", err)
		panic(err)

	}
	// for i := range data.Apartments {
	// 	fmt.Printf("%+v\n", data.Apartments[i])
	// }
	return &data, nil
}
