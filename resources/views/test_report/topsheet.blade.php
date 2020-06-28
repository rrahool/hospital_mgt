

<html>
    <head>

        <style>

            .width-100{
                width: 100%;
            }

            .width-80{
                width: 80%;
            }

            .width-25{
                width: 25%;
            }

            .font-15{
                font-size: 15px;
            }
            .no_border{
                border: none;
            }
        </style>

    </head>

    <body class="width-100" style="alignment: center ;">

    <div class="width-100" >

        <div class="width-80" style="margin-left: 10%; margin-top: 20px; height: 120px" >
            <Table class="width-100; " >

            </Table>
        </div>
    </div>

    <div style="border: 1px solid black; border-radius: 5px; margin-left: 10%; margin-top: 30px" class="width-80">
        <table  class="width-100" >
            <tr style="width: 100%;" class="no_border font-15">
                <td class="no_border">Patient Name  <b>: {{$info->patient_name}}</b></td>
                <td class="no_border">Sex  : {{$info->gender}}</td>
                <td class="no_border">Age  : {{$info->age}}</td>
            </tr>
        </table>

        <table  class="width-80"  >
            <tr style="width: 100%" class="no_border font-15">
                <td class="no_border">PROF. / DOCTOR  <b>: {{$info->client_name}}</b></td>
            </tr>
        </table>

        <table  class="width-80" >
            <tr style="width: 100%" class="no_border font-15">
                <td class="no_border">Id/Reg Number  <b>: {{$info->memo_no}}</b></td>
                <td class="no_border">Date of Receive  : <?=date('d/m/y',$info->delivery_date)?></td>
                <td class="no_border">Date of Report  : <?=date('d/m/y',$info->entry_date)?></td>
            </tr>
        </table>
    </div>

    <div style="height: 680px">

    </div>

    <div style=" margin-left: 10%; margin-right:10%; height: 100px; ">

        <table class="width-100">
            <tr>
                <td>Checked By</td>
                <td style="text-align: center">Prepared by</td>
                <td style="text-align: right">Consultant</td>
            </tr>
        </table>
    </div>


    <script>
        window.print();
    </script>
    </body>
</html>
