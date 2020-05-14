let valid = false; // stop condition

$(document).ready(function () {
    const game = $('#game');

    let current = 'X'; // first player starts with X
    let start_x = -1, start_y = -1;

    if (Math.random() <= 0.5) // incepe calculatorul
    {
        start_x = Math.floor((Math.random() * 3));
        start_y = Math.floor((Math.random() * 3));
    }

    let matrix = [[-1, -1, -1], [-1, -1, -1], [-1, -1, -1]]; // fill the matrix with empty slots. (-1 means AVAILABLE)

    for (let i of [0, 1, 2]) {
        let tr = $('<tr>'); // initialize empty row
        for (let j of [0, 1, 2]) {
            let td = $('<td>'); // initialize empty cell
            if (i === start_x && j === start_y) { // if the computer has played their move, we insert the "X" in the table cell
                td.html(current);
                current = '0'; // set the current symbol to "0"
                matrix[i][j] = 'X'; // insert in the matrix the "X"
            }
            td.on('click', function () { // listener for on-click events
                if (td.html() === "" && !valid) {
                    td.html(current);
                    matrix[i][j] = current; // insert the current symbol on the clicked tile

                    $.ajax({ // send a POST request via AJAX having data in (.json) format
                        method: 'POST',
                        url: 'index.php',
                        data: "data=" + JSON.stringify({matrix: matrix, current: current === 'X' ? '0' : 'X'}),
                        dataType: 'json',
                        success: function (data) {
                            if (data['positions'][0] !== undefined) {
                                let positions = data['positions'];
                                matrix[positions[0]][positions[1]] = current === '0' ? 'X' : '0'; // change the current symbol
                                $($(game.find('tr')[positions[0]]).find('td')[positions[1]]).html(current === '0' ?
                                    'X' : '0'); // insert "X" or "0", depending on the current symbol
                            }
                            if (data['valid'] !== 0) // there must be a winner
                            {
                                valid = true;
                                $('#done').html(data['valid'] === 1 ? "You won" : data['valid'] === 2 ?
                                    "Computer won" : "Draw"); // display the winner
                            }
                        }
                    });
                }
            });
            td.addClass('cell');
            tr.append(td); // add the modified cell to the row
        }
        game.append(tr); // add the modified row to the matrix
    }
});