package parser

import (
	"backend-test/internal/domain"
	"encoding/xml"
	"fmt"
	"io/ioutil"
	"os"
)

func Parse() {
	xmlData, err := os.Open("test.xml")

	if err != nil {
		panic(err)
	}
	xmlFile, _ := ioutil.ReadAll(xmlData)

	var data domain.Data
	err = xml.Unmarshal([]byte(xmlFile), &data)
	if err != nil {
		fmt.Printf("Error unmarshalling XML: %v\n", err)

	}
	for i := range data.Apartments {
		fmt.Printf("%+v\n", data.Apartments[i])
	}

}
