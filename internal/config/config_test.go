package config

import (
	"testing"

	"github.com/stretchr/testify/assert"
)

func TestReadConfig(t *testing.T) {

	expected := &Db_config{
		Database: Database{
			Host:     "localhost",
			Port:     "5432",
			Username: "postgres",
			Password: "postgres",
			Dbname:   "backend_Interview",
		},
		Application_cfg: Application_cfg{
			Path_xml: "test.xml",
		},
	}

	actual := MustLoad()

	assert.Equal(t, expected, actual)

}
