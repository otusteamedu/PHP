$(document).ready(() => {

    $.get('/films').done((films) => {
        films.forEach(film => {
            $('#films tbody')
                .append(
                    `<tr>
                        <td>${film.id}</td>
                        <td><a href="/films?id=${film.id}" target="_blank">${film.title}</a></td>
                        <td>${film.duration}</td>
                        <td>
                        ${film.genres.map(g => `<a href="/films?genre_id=${g.id}" target="_blank">${g.name}</a>`).join(', ')}
                        </td>
                    </tr>`
                );
        });
    });

    $.get('/genres').done((genres) => {
        genres.forEach(genre => {
            $('#genres tbody').append(
                `<tr>
                    <td>${genre.id}</td>
                    <td><a href="/films?genre_id=${genre.id}" target="_blank">${genre.name}</a></td>
                </tr>`
            );
            $('#genre_select').append(`<option value="${genre.id}">${genre.name}</option>`);
        });
    });
});