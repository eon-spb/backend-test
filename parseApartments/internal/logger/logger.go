package logger

import "go.uber.org/zap"

type Logger struct {
	Log zap.SugaredLogger
}

func New() *Logger {

	// Create registration Zap
	logg, err := zap.NewDevelopment()
	if err != nil {
		panic(err)
	}

	defer logg.Sync()

	// Create SugaredLogger
	sugar := *logg.Sugar()

	return &Logger{Log: sugar}
}
