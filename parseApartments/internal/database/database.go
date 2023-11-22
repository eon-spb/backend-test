package database

import (
	"database/sql"

	_ "github.com/jackc/pgx/v5/stdlib"
)

type Database struct {
	database *sql.DB
}

func NewConnect(DSN string) (*Database, error) {

	// !!! Need change with enviroment variable !!!
	db, err := sql.Open("pgx", DSN)
	if err != nil {
		return nil, err
	}

	_, err = db.Exec("CREATE TABLE IF NOT EXISTS apartment" +
		"(id UUID NOT NULL PRIMARY KEY, s_total NUMERIC(10, 2) NOT NULL, s_living NUMERIC(10, 2) NOT NULL, s_kitchen NUMERIC(10, 2) NOT NULL, " +
		" height INT, price NUMERIC(15, 2) CHECK (price >= 0), floor INT)")
	if err != nil {
		return nil, err
	}

	return &Database{
		database: db,
	}, nil
}

func (d *Database) SaveApartment(id string, sTotal, sLiving, sKitchen float32, price float64, height, floor int) error {
	_, err := d.database.Exec("INSERT INTO apartment(id, s_total, s_living, s_kitchen, height, price, floor)"+
		"values($1, $2, $3, $4, $5, $6, $7)", id, sTotal, sLiving, sKitchen, height, price, floor)
	return err
}

func (d *Database) Close() {
	d.database.Close()
}
