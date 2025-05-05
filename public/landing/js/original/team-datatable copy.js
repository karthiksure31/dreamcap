function showDataTable(dataSet) {
    $('#teamTable').DataTable({
        bDestroy: true,
        dom: 'Bfrtip',
        processing: true,
        buttons: [
            // 'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        autoWidth: true,
        data: dataSet,
        columns: [{
            title: "No"
        },
        {
            title: "Player 1"
        },
        {
            title: "Player 2"
        },
        {
            title: "Player 3"
        },
        {
            title: "Player 4"
        },
        {
            title: "Player 5"
        },
        {
            title: "Player 6"
        },
        {
            title: "Player 7"
        },
        {
            title: "Player 8"
        },
        {
            title: "Player 9"
        }
        ],
    });
}