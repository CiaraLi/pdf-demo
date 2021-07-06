package main

import (
	"github.com/pdfcpu/pdfcpu/pkg/api"
	"github.com/pdfcpu/pdfcpu/pkg/pdfcpu"
)

func main() {
	oldFile := "./pdf.pdf"
	newFile := "./output.pdf"
	waterFile := "./water.png"

	water(oldFile, newFile, waterFile)
}

func water(oldFile string, newFile string, waterFile string) {
	onTop := true
	wm, _ := pdfcpu.ParseImageWatermarkDetails(waterFile, "sc:4 abs, d:1, op:.4, pos:c", onTop, 1)
	api.AddWatermarksFile(oldFile, newFile, nil, wm, nil)
}
