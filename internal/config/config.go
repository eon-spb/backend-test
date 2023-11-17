package config

import (
	"log"

	"github.com/ilyakaznacheev/cleanenv"
)

type Db_config struct {
	Database        `yaml:"database_cfg"`
	Application_cfg `yaml:"application"`
}

type Database struct {
	Host     string `yaml:"host"`
	Port     string `yaml:"port"`
	Username string `yaml:"username"`
	Password string `yaml:"password"`
	Dbname   string `yaml:"dbname"`
}
type Application_cfg struct {
	Path_xml string `yaml:"path_xml"`
}

func MustLoad() *Db_config {
	var path = "internal/config/config.yml"

	var cfg Db_config

	if err := cleanenv.ReadConfig(path, &cfg); err != nil {
		log.Fatalf("Cannot read config: %s ", err)
	}
	return &cfg
}
