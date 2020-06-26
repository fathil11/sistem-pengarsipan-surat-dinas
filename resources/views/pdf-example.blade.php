{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <style>
        html { margin: 0px}
        .margin { margin: 10px}
    </style>
</head>
<body>
    <div style="background-color: darkgray; width: 100%; height:30mm;">

    </div>
    <table class="margin">
        <tr>
            <td>Judul Surat</td>
            <td>:</td>
            <td>{{ $mail->mail->title }}</td>
        </tr>
        <tr>
            <td>Direktori Surat</td>
            <td>:</td>
            <td>{{ $mail->mail->directory_code }}</td>
        </tr>
        <tr>
            <td>Kode Surat</td>
            <td>:</td>
            <td>{{ $mail->mail->code }}</td>
        </tr>
        <tr>
            <td>Memo Sekretaris</td>
            <td>:</td>
            <td>{{ $mail->memo->secretary }}</td>
        </tr>
        <tr>
            <td>Memo Kepala Dinas</td>
            <td>:</td>
            <td>{{ $mail->memo->hod }}</td>
        </tr>
    </table>
</body>
</html> --}}
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Aloha!</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    td{
        vertical-align: top;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>
    <img src="https://modulkomputer.com/wp-content/uploads/2018/03/contoh-kop-surat-kementrian-pendidikan.png" alt="" style="max-width: 100%;"/>
    <hr>
    <table width=100%>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $mail->mail->directory_code }}</td>
                    </tr>
                    <tr>
                        <td>Pengirim</td>
                        <td>:</td>
                        <td>{{ $mail->mail->origin }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>Disposisi {{ $mail->mail->title }}</td>
                    </tr>
                </table>
            </td>
            @php
                use Carbon\Carbon;
            @endphp
            <td style="text-align: right">
                <table>
                    <tr>
                        <td>Tanggal Masuk</td>
                        <td>:</td>
                        <td>{{ $mail->mail->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat</td>
                        <td>:</td>
                        <td>{{ $mail->mail->mail_created_at }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <hr>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <hr>
    <table width=100%>
        <tr>
            <td>Catatan Sekretaris</td>
            <td>:</td>
            <td>{{ $mail->memo->secretary }}</td>
        </tr>
        <tr>
            <td>Catatan Kepala Dinas</td>
            <td>:</td>
            <td>{{ $mail->memo->hod }}</td>
        </tr>
    </table>

</body>
</html>
