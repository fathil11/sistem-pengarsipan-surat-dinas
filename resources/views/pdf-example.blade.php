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
    <title>Disposisi</title>

    <style type="text/css">
        * {
            font-family: Arial;
        }

        td {
            vertical-align: top;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .gray {
            background-color: lightgray
        }

        .content {
            font-size: 18px;
        }

        .header {
            font-weight: 600;
            font-size: 20px;
        }
    </style>

</head>

<body>
    <img src="https://modulkomputer.com/wp-content/uploads/2018/03/contoh-kop-surat-kementrian-pendidikan.png" alt=""
        style="max-width: 100%;" />
    <hr>
    <table width=100% class="content">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Kode</td>
                        <td>:</td>
                        <td>{{ $mail->mail->directory_code }}</td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $mail->mail->title }}</td>
                    </tr>
                    <tr>
                        <td>Sifat Surat</td>
                        <td>:</td>
                        <td>{{ $mail->mail->reference->type }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat / Nomor</td>
                        <td>:</td>
                        <td>{{  $mail->mail->mail_created_at->isoFormat('DD MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td>Asal Surat</td>
                        <td>:</td>
                        <td>{{ $mail->mail->origin }}</td>
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
                        <td>{{ $mail->mail->created_at->isoFormat('DD MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Surat</td>
                        <td>:</td>
                        <td>{{ $mail->mail->mail_created_at->isoFormat('DD MMMM Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <hr>
    <p class="header">Catatan Sekretaris</p>
    <p class="content">{{ $mail->memo->secretary }}</p>
    <br>
    <hr>
    <p class="header">Catatan Kepala Dinas</p>
    <p class="content">{{ $mail->memo->hod }}</p>

</body>

</html>
