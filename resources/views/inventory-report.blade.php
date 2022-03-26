<!DOCTYPE html>
<html>

<head>

</head>

<style>
    .page-header, .page-header-space {
  height: 100px;
}

.page-footer, .page-footer-space {
  height: 50px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  background-color: #ffffff;
  width: 100%;
  border-top: 1px solid black; /* for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  background-color: #ffffff;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
}

.page {
  page-break-after: always;
}

.table-items {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.td-items, .th-items {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px;
}

.tr-items:nth-child(even) {
  background-color: #dddddd;
}

@page {
  margin: 20mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   button {display: none;}
   
   body {margin: 0;}
}
</style>

<body>
  <div class="page-header" style="text-align: center">
    Ming Computer Solutions<br/>
    Panabo Branch<br/>
    Income Statement Date
    <br/>
    <button type="button" onClick="window.print()" style="background: pink">
      PRINT ME!
    </button>
  </div>

  <div class="page-footer">
    Ming Computer Solutions
  </div>

  <table style="width: 100%">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody style="width: 100%">
      <tr>
        <td>
          <!--*** CONTENT GOES HERE ***-->
          <div style="width: 100%" class="page" style="line-height: 3;">
            <table style="width: 100%" class="table-items">
                <tr class='tr-items'>
                  <th class="th-items">Id</th>
                  <th class="th-items">Name</th>
                  <th class="th-items">Sold</th>
                  <th class="th-items">Price</th>
                  <th class="th-items">Total</th>
                </tr>
                @php $total = 0;@endphp
                @foreach ($data as $item)
                  <tr class='tr-items'>
                    <td class="td-items">{{ $item->id }}</td>
                    <td class="td-items" style="width: 100%">{{ $item->name }}</td>
                    <td class="td-items">{{ $item->sold }}</td>
                    <td class="td-items" style="padding-left: 10px; padding-right: 10px">{{ $item->price }}</td>
                    <td class="td-items" style="padding-left: 10px; padding-right: 10px">{{ ($item->price*$item->sold) }}</td>
                  </tr>
                  <div style="display: none">{{$total += $item->price*$item->sold}}</div>
                @endforeach
              </table>
              <div style="text-align: end">
                <h1>Total Income: {{ $total }}</h1>
              </div>
          </div>
        </td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>

  </table>

</body>

</html>