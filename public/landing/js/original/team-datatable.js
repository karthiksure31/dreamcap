function showDataTable(dataSet) {
    console.log("dataSet");
    console.log(dataSet);
    $('#teamTable').DataTable({
        bDestroy: true,
        dom: 'Bfrtip',
        processing: true,
        buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        autoWidth: true,
        data: dataSet.map(row => formatRow(row)), // Format each row before adding to DataTable
        columns: [
            { title: "No" },
            { title: "Player 1" },
            { title: "Player 2" },
            { title: "Player 3" },
            { title: "Player 4" },
            { title: "Player 5" },
            { title: "Player 6" },
            { title: "Player 7" },
            { title: "Player 8" },
            { title: "Player 9" }
        ],
    });
}

// Function to format each row before adding to DataTable
function formatRow(row) {
    console.log("renderPlayer");
    console.log(data);
    return row.map((player, index) => {
        if (index === 0) return player; // Keep "No" column as is

        if (!player.includes(" | ")) return player; // Skip if not formatted properly

        var playerDetails = player.split(" | "); // Split details
        if (playerDetails.length < 5) return player; // Return original if missing parts

        var playerImage = playerDetails[4] ? playerDetails[4] : 'images/users/default.jpg'; // Image
        var playerName = playerDetails[0]; // Name
        var playerPosition = playerDetails[2]; // Position

        return `
            <div class="player-info" style="text-align: center;">
                <img src="${playerImage}" alt="${playerName}" class="player-img"
                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"
                    onerror="this.onerror=null; this.src='images/users/default.jpg';">
                <br>
                <strong>${playerName}</strong><br>
                <small>${playerPosition}</small>
            </div>
        `;
    });
}
