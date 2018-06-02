<h2>Logs for  {{date('M, Y', time())}}</h2>
<div class="list-group">
    <div class="list-group-item">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In </th>
                    <th>Time Out</th>
                </tr>
            </thead>
            {{-- Get and show all user reports --}}
            <tbody>
                @if(count($reports) > 0)
                    @foreach($reports as $report)
                        <tr>
                        <td>{{date('D j/M/y', strtotime($report->created_at))}}</td>
                            <td>{{date('H:i', strtotime($report->time_in))}} Hrs</td>
                            <td>@if($report->status == 1) - @else {{date('H:i', strtotime($report->time_out))}} Hrs @endif</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="3"><p class="cl-error">NO DATA REPORT FOR THIS USER</p></td>
                </tr>
                @endif
            </tbody>
        </table>     
    </div>
    <br/>
</div>
<button class="btn btn-primary" id="print">Print Report</button>
<a href="{{route('reports.export.excel')}}" class="btn btn-primary">Export As Excel</a>
<a href="{{route('reports.export.csv')}}" class="btn btn-primary">Export To CSV</a>

{{-- This container will be printed --}}

<div id="report-to-print" style="display:none;">
    <div style="border-bottom:3px solid #333; margin-bottom:40px;">
        <h1 style="text-align:center;">Train Analytics</h1>
    </div>
    <p style="position: absolute; right:10px; margin-top:-30px;"><strong>Date : </strong> {{date('D j/M/Y', time())}}</p>
    <h3 style="text-align:center; margin-bottom:30px;">Check Ins for {{$user->name}}</h3>
    <table style="border-collapse: collapse; border-spacing: 0; width:100%;">
        <thead>
            <tr>
                <th style="padding: 10px 0; border-bottom:1px solid #999; border-top:1px solid #999; text-transform:uppercase; text-align:left;">Date</th>
                <th style="padding: 10px 0; border-bottom:1px solid #999; border-top:1px solid #999; text-transform:uppercase; text-align:left;">Time In </th>
                <th style="padding: 10px 0; border-bottom:1px solid #999; border-top:1px solid #999; text-transform:uppercase; text-align:left;">Time Out</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reports) > 0)
                @foreach($reports as $report)
                    <tr>
                        <td style="padding: 10px 0; border-bottom:1px solid #999;">{{date('D j/M/y', strtotime($report->created_at))}}</td>
                        <td style="padding: 10px 0; border-bottom:1px solid #999;">{{date('H:i', strtotime($report->time_in))}} Hrs</td>
                        <td style="padding: 10px 0; border-bottom:1px solid #999;">@if($report->status == 1) - @else {{date('H:i', strtotime($report->time_out))}} Hrs @endif</td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="3"><p class="cl-error">NO DATA REPORT FOR THIS USER</p></td>
            </tr>
            @endif
        </tbody>
    </table>
    <p style="margin-top:45px;">{{Auth::user()->name}}</p>
    <p style="margin-top:-15px; text-transform:capitalize">({{Auth::user()->type}})</p>
</div>
<script type="text/javascript">
    // Print report
    function printDocument() {
        var contents = document.getElementById("report-to-print").innerHTML;var frame = document.createElement('iframe');
        frame.name = "frame";frame.style.position = "absolute";frame.style.top = "-1000000px";document.body.appendChild(frame);
        var doc = (frame.contentWindow) ? frame.contentWindow : (frame.contentDocument.document) ? frame.contentDocument.document : frame.contentDocument;
        doc.document.open();doc.document.write('<html><head><title>Document</title>');doc.document.write('</head><body>');
        doc.document.write(contents);doc.document.write('</body></html>');doc.document.close();
        setTimeout(function () {
            window.frames["frame"].focus();window.frames["frame"].print();document.body.removeChild(frame);
        }, 500);
        return false;
    }
    document.getElementById("print").addEventListener("click", printDocument, null);
</script>