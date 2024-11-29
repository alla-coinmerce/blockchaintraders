<x-admin.layout>

    <h1>Message</h1>

    <section>
        <table>
            <tbody>
                <tr>
                    <th class="align-left">From:</th>
                    <td>{{ $message->name }}</td>
                </tr>
                <tr>
                    <th class="align-left">Email:</th>
                    <td>{{ $message->email }}</td>
                </tr>
                <tr>
                    <th class="align-left">Subject:</th>
                    <td>{{ $message->subject }}</td>
                </tr>
                <tr>
                    <th class="align-left">Received at:</th>
                    <td>{{ $message->created_at }}</td>
                </tr>
                <tr>
                    <th class="align-left">User language:</th>
                    <td>{{ $message->locale }}</td>
                </tr>
                <tr>
                    <th class="align-left">URL:</th>
                    <td>{{ $message->url }}</td>
                </tr>
                <tr>
                    <th class="align-left">Form:</th>
                    <td>{{ $message->form_tag }}</td>
                </tr>
                <tr>
                    <th class="align-left">Message:</th>
                    <td style="white-space: pre-line">{{ $message->message }}</td>
                </tr>
            </tbody>
        </table>

        @php
            $linebreak = "%0D%0A";
            $string = "Beste ".$message->name.",".$linebreak.$linebreak.$linebreak."Origineel bericht:".$linebreak.$linebreak.$message->message.$linebreak.$linebreak;
            $order = array("\r\n", "\n", "\r");
            $string = str_replace($order, "@#$%", $string);
            $string = str_replace("@#$%", $linebreak, $string);
        @endphp

        <a class="button" href="mailto:{{ $message->email }}?subject={{ $message->subject }}&body={{ $string }}">
            Reply
        </a>

    </section>

</x-admin.layout>