package main

import (
	"github.com/pdfcpu/pdfcpu/pkg/api"
	"github.com/pdfcpu/pdfcpu/pkg/pdfcpu"
	"os"
)

func main() {

	oldFile := "./pdf.pdf"
	newFile := "./output.pdf"
	waterFile := "./water.png"
	if (os.Args[1] != "") {
		oldFile = os.Args[1]
	}
	if (os.Args[2] != "") {
		newFile = os.Args[2]
	}
	if (os.Args[3] != "") {
		waterFile = os.Args[3]
	}
	water(oldFile, newFile, waterFile)
}

func water(oldFile string, newFile string, waterFile string) {
	onTop := true
	wm, _ := pdfcpu.ParseImageWatermarkDetails(waterFile, "sc:1 rel, rot: 0.0, op:.4, pos:c", onTop, 1)
	api.AddWatermarksFile(oldFile, newFile, nil, wm, nil)
}
