let pdfDoc = null
let pageNum = 1
let pageIsRendering = false
let pageNumIsPending = null

const scale = 1.5
const canvas = document.getElementById('pdf-render')
const ctx = canvas.getContext('2d')
const fileLoader = document.getElementById('fileInput')

pdfjsLib.GlobalWorkerOptions.workerSrc = '/js/vendor/pdf.worker.js';


//Render page
const renderPage = num => {
    pageIsRendering = true
    //Get Page
    pdfDoc.getPage(num).then(page => {
        //Set Scale
        const viewport = page.getViewport({scale})
        canvas.height = viewport.height
        canvas.width = viewport.width

        const renderCtx = {
            canvasContext: ctx,
            viewport
        }

        page.render(renderCtx).promise.then(() => {
            pageIsRendering = false
            if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending)
                pageNumIsPending = null
            }
        })

        //Output current page number
        document.getElementById('page-num').textContent = num
    })
}

//Check for pages rendering
const queueRenderPage = num => {
    if (pageIsRendering) {
        pageNumIsPending = num
    } else {
        renderPage(num)
    }
}

//Show prev page
const showPrevPage = () => {
    if (pageNum <= 1) {
        return
    }
    pageNum--
    queueRenderPage(pageNum)
}

//Show next page
const showNextPage = () => {
    if (pageNum >= pdfDoc.numPages) {
        return
    }
    pageNum++
    queueRenderPage(pageNum)
}

//Load document
const loadDocument = () => {

    const uri = document.getElementById('pdf-render').dataset.src;

    //Get Document
    pdfjsLib.getDocument(uri).promise
        .then(
            pdfDoc_ => {
                pdfDoc = pdfDoc_
                document.getElementById('page-count').textContent = pdfDoc.numPages

                renderPage(pageNum)
            }
        )
}


//Events
document.getElementById('show_pdf').addEventListener('click', loadDocument, false)
document.getElementById('prev_page').addEventListener('click', showPrevPage, false)
document.getElementById('next_page').addEventListener('click', showNextPage, false)
