<h1>Salam, Sizin saytdan gələn bir mesajınız var.</h1>
<table class="table table-strip table-bordered">
    <thead>
    <tr>
        <th>Ad</th>
        <th>Email</th>
        <th>Mətn</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $data['fullName'] ?? '' }} </td>
        <td>{{ $data['email'] ?? '' }} </td>
        <td>{{ $data['subject'] ?? '' }} </td>
    </tr>
    </tbody>
</table>
