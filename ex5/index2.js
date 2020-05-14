function find_add(component, preview_file, path) {
	$.getJSON('index.php?path=' + path, function (data) { // decode the (.json) data received from server side
		let ul = $('<ul>'); // whole hierarchy -> this will recursively build the path (the treeview contains multiple <ul>-s)
		for (let file of data) { // iter through the files and handle behaviour for every type (dir/txt)
			let li = $('<li>'); // each <li> contains information about one file (the <ul> contains multiple <li>-s)
			let div = $('<div>'); // file naming will be encapsulated in this <div> element
			div.html(file['file']);
			li.append(div);
			if (file['dir'] === true && file['content'] === "") { // it is a directory
				div.on("click", function () { // handle click event
					file['opened'] = !file['opened']; // change the open state of the directory (closed/opened)
					if (!file['opened']) {
						for (let item of li.find('ul')) // do not show any inner content of the directory if it is closed
							$(item).html("");
					}
					else {
						find_add(li,  preview_file, path + '/' + file['file']); // recursive call (show inner content of dir)
					}
				});
			}
			else { // it is a text file
				div.on("click", function () {
					preview_file.html(atob(file['content'])); // atob decodes a base-64 encoded string (received from php call)
				});
			}
			ul.append(li); // append the content to the list
		}
		component.append(ul); // append the list to the treeview
	});
}

$(window).ready(function () { // on document ready, the tree view is populated with the data
	let treeview = $('#treeview');
	let preview_file = $('#preview_file'); // HTML element where we display the content of a text file

	find_add(treeview, preview_file, '.'); // call the recursive search function
});
