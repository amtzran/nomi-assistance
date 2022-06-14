<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CONTROL DE ASISTENCIA POR EMPLEADO</title>
</head>
<style>
    @page {
        margin: 0;
    }
    body{
        font-family: 'MontserratBold', Helvetica, Arial, sans-serif
    }
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 100px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }
    .styled-table thead tr {
        background-color: #324496;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }
    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #324496;
    }
    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #324496;
    }
</style>
<body>

{{--//headers--}}
<div style="margin: 0px;">
    <div style="margin-bottom: 0px; text-align: left; padding-left: 20px; margin-top: -30px;">

        <div style="text-align: center; margin-bottom: 0px; margin-top: 30px;">
            <h2 style="font-weight: bold; margin-bottom: 0px; color: #324496;">CONTROL DE ASISTENCIA POR EMPLEADO</h2>
        </div>

    </div>
</div>

<div style="text-align: center; ; margin: 50px 20px 0 20px;">
    <p style="margin-top: 0px; margin-bottom: 7px">
        <span style="font-size:10pt"></span>
    </p>
    <hr>
</div>

<div style="text-align: center; ; margin: 10px 20px 0 20px;">
    <p style="margin-top: 0px; margin-bottom: 7px; font-size:12pt; line-height:25px;">
        {{$employee->nombre . ' ' . $employee->apellido_paterno . ' ' . $employee->apellido_materno}}
    </p>
    <hr>
</div>

<div style="text-align: center; ; margin: 10px 20px 0 20px;">
    <table class="styled-table" style="width: 750px">
        <thead>
        <tr>
            <th>FECHA</th>
            <th>DIA</th>
            <th>ENTRADA</th>
            <th>SALIDA</th>
            <th>EXTRAS (MINUTOS)</th>
        </tr>
        </thead>
        <tbody style="text-align: center;">
        @foreach($assistances as $assistance)
            <tr>
                <td style="color: #324496; font-weight: bold;">{{$assistance['fecha_entrada']}}</td>
                <td>{{$assistance['dia']}}</td>
                <td>{{$assistance['hora_entrada']}}</td>
                <td>{{$assistance['hora_salida']}}</td>
                <td>{{$assistance['extra_minutes']}}</td>
            </tr>
        @endforeach
        <tr>
            <td style="color: #324496; font-weight: bold;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>DIAS TRABAJADOS</td>
            <td>{{$diasTrabajados}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>DIAS DESCANSO</td>
            <td>{{$diasDescanso}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>RETARDOS</td>
            <td>{{$retardos}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>FALTAS</td>
            <td>{{$faltas}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>HORAS TRABAJADAS</td>
            <td>{{$horasTrabajadas}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td>TOTAL EXTRAS (MINUTOS)</td>
            <td>{{$minutosExtras}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <!-- and so on... -->
        </tbody>
    </table>
</div>

<br><br>

<div style="text-align: center; ; margin: 10px 20px 0 20px;">
    <p style="margin-top: 0px; margin-bottom: 7px; font-size:15pt">
        FIRMA DE CONFORMIDAD
    </p>
    <br><br><br><br>
    ________________________________________
    <br>
    <span style="font-weight: bold;">{{$employee->nombre . ' ' . $employee->apellido_paterno . ' ' . $employee->apellido_materno}}</span>
    <br>
    Cancún, Quintana Roo. {{$now}} a las {{$hour}}
</div>

</body>
</html>
