let content =`
<div id="content-quality">
  <div class="row ps-3 pe-3 mt-3">
    <div class="col">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="inline-tab" data-bs-toggle="tab" data-bs-target="#inline" type="button" role="tab" aria-controls="inline" aria-selected="true">
            In line
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="endline-tab" data-bs-toggle="tab" data-bs-target="#endline" type="button" role="tab" aria-controls="endline" aria-selected="false">
            End line
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="lbo-tab" data-bs-toggle="tab" data-bs-target="#lbo" type="button" role="tab" aria-controls="lbo" aria-selected="false">
            LBO
          </button>
        </li>
      </ul>
      
      <!-- Tab panes -->
      <div class="tab-content">

        <div class="tab-pane active" id="inline" role="tabpanel" aria-labelledby="inline-tab">
          profile
        </div>

        <div class="tab-pane" id="endline" role="tabpanel" aria-labelledby="endline-tab">
          <!-- card -->
          <div class="row mt-2">
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-end-ppm">
                    <h3 class="mb-0 text-danger">0% <span class="fas fa-long-arrow-alt-up"></span></h3>
                    <span><b>Defect PPM</b></span>
                    </div>
                    <div class="align-self-center" id="card-end-ppm-actual">
                      <span>Actual</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-end-ppm-goal">
                      <span>Goal</span>
                      <h3 class="mb-0" id="card-end-target">0</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-end-def">
                      <h3 class="mb-0 text-danger">0% <span class="fas fa-long-arrow-alt-up"></span></h3>
                      <span><b>Defect Qty.</b></span>
                    </div>
                    <div class="align-self-center" id="card-end-def-act">
                      <span>Actual</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-end-def-goal">
                      <span>Target</span>
                      <h3 class="mb-0">0</h3>
                    </div>                  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-end-size">
                      <h3 class="mb-0 text-danger">0% <span class="far fa-clipboard"></span></h3>
                      <span><b>Sampling size</b></span>
                    </div>
                    <div class="align-self-center" id="card-end-size-ss">
                      <span>Sampling size</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-end-size-lot">
                      <span>Lot size</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end card -->
          <div class="row mt-3">
            <div class="col">
              <div id="chart-line-end" class="border p-3">
                
              </div>
            </div> 
          </div>
          <div class="row mt-3">
            <div class="col-sm-4">
              <div id="chart-defect-end" class="border p-2">
                
              </div>
            </div> 
            <div class="col-sm-8">
              <div id="chart-style-end" class="border p-2">
                
              </div>
            </div>
          </div>
          <div class="row mt-3 mb-4">
            <div class="col">
              <div id="chart-defect-ppm-end" class="border p-2">
                
              </div>
            </div> 
          </div>
        </div>
        
        <div class="tab-pane" id="lbo" role="tabpanel" aria-labelledby="lbo-tab">
          <!-- card -->
          <div class="row mt-2">
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-lbo-ppm">
                     <h3 class="mb-0 text-danger">0% <span class="fas fa-long-arrow-alt-up"></span></h3>
                     <span><b>Defect PPM</b></span>
                    </div>
                    <div class="align-self-center" id="card-lbo-ppm-actual">
                      <span>Actual</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-lbo-ppm-goal">
                      <span>Goal</span>
                      <h3 class="mb-0" id="card-lbo-target">0</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-lbo-def">
                      <h3 class="mb-0 text-danger">0% <span class="fas fa-long-arrow-alt-up"></span></h3>
                      <span><b>Defect Qty.</b></span>
                    </div>
                    <div class="align-self-center" id="card-lbo-def-act">
                      <span>Actual</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-lbo-def-goal">
                      <span>Target</span>
                      <h3 class="mb-0">0</h3>
                    </div>                  
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div class="align-self-center" id="card-lbo-size">
                      <h3 class="mb-0 text-danger">0% <span class="far fa-clipboard"></span></h3>
                      <span><b>Sampling size</b></span>
                    </div>
                    <div class="align-self-center" id="card-lbo-size-ss">
                      <span>Sampling size</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                    <div class="align-self-center" id="card-lbo-size-lot">
                      <span>Lot size</span>
                      <h3 class="mb-0">0</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end card -->
          <div class="row mt-3">
            <div class="col">
              <div id="chart-line" class="border p-3">
                
              </div>
            </div> 
          </div>
          <div class="row mt-3">
            <div class="col-sm-4">
              <div id="chart-defect" class="border p-2">
                
              </div>
            </div> 
            <div class="col-sm-8">
              <div id="chart-style" class="border p-2">
                
              </div>
            </div>
          </div>
          <div class="row mt-3 mb-4">
            <div class="col">
              <div id="chart-defect-ppm" class="border p-2">
                
              </div>
            </div> 
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
`;

function formatNumber(number){
  return new Intl.NumberFormat().format(number);
}

export function showContent(){
  return content;
}

export function loadCharts(){
  // LBO
  let dataActual = [];
  let dataTarget = [];
  let dataLine = [];
  
  let options = {
    series: [
      {name: 'Actual', type: 'column', data: dataActual}, 
      {name: 'Goal', type: 'line', data: dataTarget}
    ],
    chart: {height: 350, type: 'bar'},
    stroke: {width: [0, 4]},
    title: {text: 'Line defect PPM'},
    dataLabels: {
      enabled: true, 
      enabledOnSeries: [0],
      formatter: function (val, opts) {
        return formatNumber(val);
      }
    },
    labels: dataLine              
  };
  const chartLine = new ApexCharts(document.querySelector("#chart-line"), options);
  chartLine.render();

  options = {
    series: [
      {name: 'Actual', type: 'column', data: dataActual}
    ],
    chart: {height: 350, type: 'bar'},
    plotOptions: {
      bar :{horizontal: true}
    },
    title: {text: 'Name of deffect (qty)'},
    dataLabels: {
      enabled: true, 
      dataLabels: {position: 'top'},
      formatter: function (val, opts) {
        return formatNumber(val);
      }
    },
    labels: dataLine,
    xaxis: {
      categories: ['Deffect 1','Defect 2', 'Defect 3', 'Defect 4', 'Defect 5', 'Defect 6']
    }
  };

  const chartDefect = new ApexCharts(document.querySelector("#chart-defect"), options);
  chartDefect.render();

  options = {
    series: [
      {name: 'Actual', type: 'column', data: dataActual}, 
      {name: 'Goal', type: 'line', data: dataTarget}
    ],
    chart: {height: 350, type: 'bar'},
    stroke: {width: [0, 4]},
    title: {text: '10 Style with highest defects (PPM)'},
    dataLabels: {
      enabled: true, 
      enabledOnSeries: [0],
      formatter: function (val, opts) {
        return formatNumber(val);
      }
    },
    labels: dataLine,
    xaxis: {}
  };
  const chartStyle = new ApexCharts(document.querySelector("#chart-style"), options);
  chartStyle.render();

  options = {
    series: [
      {name: 'Actual', type: 'column', data: dataActual}, 
      {name: 'Goal', type: 'line', data: dataTarget}
    ],
    chart: {height: 350, type: 'bar'},
    stroke: {width: [0, 4]},
    title: {text: 'Name of defect (PPM)'},
    dataLabels: {
      enabled: true, 
      enabledOnSeries: [0],
      formatter: function (val, opts) {
        return formatNumber(val);
      }
    },
    labels: dataLine,
    xaxis: {}
  };
  const chartDefectPpm = new ApexCharts(document.querySelector("#chart-defect-ppm"), options);
  chartDefectPpm.render();
}

export async function loadLboData(urlParam, chartLine, chartStyle, chartDefectPpm, chartDefect) {
  try {
    
    const res = await fetch("assets/api/quality.php?" + urlParam, {
      method: "GET",
      headers:{
        "Content-Type": "application/json",
      }
    });
    const output = await res.json();
    //console.log(output.lbo_period);
    //console.log(output.lbo_defect_detail);

    let arr = output.lbo_defect_detail;
    let obj = arr.find( o => o.def_line === "LINE 2");
    // console.log(obj.def_count_label);
    // console.log(obj.def_count_qty);
    // console.log(obj.def_style_label);
    // console.log(obj.def_style_ppm);
    // console.log(obj.def_style_goal);

    // LBO CARD
    let goalDef = output.lbo_sum_ss * (output.lbo_goal/1000000);
    let goalDefPer = (output.lbo_sum_defect/goalDef) * 100;
    let lboPpmAct = (output.lbo_sum_defect/output.lbo_sum_ss)*1000000;
    let lboPpmPer = ((output.lbo_sum_defect/output.lbo_sum_ss)*1000000) / output.lbo_goal;
    let lboPpmStyle = ""; let lboPpmIcon = "";
    lboPpmPer = Math.round((lboPpmPer)*100)-100
    if (lboPpmPer <= 0){
      lboPpmStyle ='text-success';
      lboPpmIcon = 'fas fa-long-arrow-alt-down';
    }else{
      lboPpmStyle ='text-danger';
      lboPpmIcon = 'fas fa-long-arrow-alt-up';
    }
    // LBO CARD PPM
    document.getElementById("card-lbo-ppm").innerHTML = `
      <h3 class="mb-0 ${lboPpmStyle}">${lboPpmPer}% <span class="${lboPpmIcon}"></span></h3>
      <span>Defect PPM</span>
    `;
    document.getElementById("card-lbo-ppm-actual").innerHTML = `
      <span>Actual</span>
      <h4 class="mb-0">${formatNumber(Math.round(lboPpmAct))}</h4>
    `;
    document.getElementById("card-lbo-ppm-goal").innerHTML = `
      <span>Goal</span>
      <h4 class="mb-0">${formatNumber(output.lbo_goal)}</h4>
    `;

    // LBO CARD DEFECT
    document.getElementById("card-lbo-def").innerHTML = `
      <h3 class="mb-0 ${lboPpmStyle}">${Math.round(goalDefPer)-100}% <span class="${lboPpmIcon}"></span></h3>
      <span>Defect Qty.</span>
    `;
    document.getElementById("card-lbo-def-act").innerHTML = `
      <span>Actual</span>
      <h4 class="mb-0">${formatNumber(output.lbo_sum_defect)}</h4>
    `;
    document.getElementById("card-lbo-def-goal").innerHTML = `
      <span>Goal</span>
      <h4 class="mb-0">${formatNumber(Math.round(goalDef))}</h4>
    `;

    // LBO CARD SAMPLING
    document.getElementById("card-lbo-size").innerHTML = `
      <h3 class="mb-0 text-success">${Math.round((output.lbo_sum_ss/output.lbo_sum_lot)*100)}% <span class="far fa-clipboard"></span></h3>
      <span>Sampling size</span>
    `;
    document.getElementById("card-lbo-size-ss").innerHTML = `
      <span>Sampling size</span>
      <h4 class="mb-0">${formatNumber(output.lbo_sum_ss)}</h4>
    `;
    document.getElementById("card-lbo-size-lot").innerHTML = `
      <span>Lot size</span>
      <h4 class="mb-0">${formatNumber(output.lbo_sum_lot)}</h4>
    `;
    
    // LBO CHART
    let options = {
      series: [
        {name: 'Actual', type: 'column', data: output.lbo_line[0].actual},
        {name: 'Goal', type: 'line', data: output.lbo_line[0].goal}
      ],
      chart: {
        height: 350, type: 'bar',
        events : {
          dataPointSelection: function(event, chartContext, config) {
            let obj = arr.find( o => o.def_line === chartContext.w.globals.labels[config.dataPointIndex]);
            if (obj !== undefined) {
              
              console.log(obj);
              console.log(obj.def_count_label);
              console.log(obj.def_count_qty);
              console.log(obj.def_style_label);
              console.log(obj.def_style_ppm);
              console.log(obj.def_style_goal);
              
              chartDefect.updateOptions({
                series:[{name:'Actual', data: obj.def_count_qty}]
              })

              chartStyle.updateOptions({
                series: [
                  {name: 'Actual', type: 'column', data: obj.def_style_ppm}, 
                  {name: 'Goal', type: 'line', data: obj.def_style_goal}
                ],
                labels: obj.def_style_label
              })

              chartDefectPpm.updateOptions({
                series: [
                  {name: 'Actual', type: 'column', data: obj.def_name_ppm}, 
                  {name: 'Goal', type: 'line', data: obj.def_name_goal}
                ],
                labels: obj.def_name_label
              })
            }
          }
        }
      },
      stroke: {width: [0, 4]},
      title: {text: 'Line defect PPM'},
      dataLabels: {
        enabled: true, 
        enabledOnSeries: [0],
        formatter: function (val, opts) {
          return formatNumber(val);
        }
      },
      fill: {
        colors: [function({ value, seriesIndex, w }) {
          if(value > output.lbo_goal) {
              return '#dc3545'
          } else {
              return '#0d6efd'
          }
        }]
      },
      labels: output.lbo_line[0].label            
    };
    chartLine.updateOptions(options);

    //CHART DEFECT QTY
    options = {
      series: [
        {name: 'Actual', data: output.lbo_defect[0].actual}
      ],
      chart: {height: 350, type: 'bar'},
      plotOptions: {
        bar :{horizontal: true}
      },
      title: {text: 'Name of deffect (qty)'},
      dataLabels: {
        enabled: true, 
        dataLabels: {position: 'top'},
        formatter: function (val, opts) {
          return formatNumber(val);
        }
      },
      labels: output.lbo_style[0].label,
      xaxis: {
        categories: output.lbo_defect[0].label
      }
    };
    chartDefect.updateOptions(options);

    //CHART STYLE PPM
    options = {
      series: [
        {name: 'Actual', type: 'column', data: output.lbo_style[0].actual}, 
        {name: 'Goal', type: 'line', data: output.lbo_style[0].goal}
      ],
      chart: {height: 350, type: 'bar'},
      stroke: {width: [0, 4]},
      title: {text: '10 Style with highest defects (PPM)'},
      dataLabels: {
        enabled: true, 
        enabledOnSeries: [0],
        formatter: function (val, opts) {
          return formatNumber(val);
        }
      },
      fill: {
        colors: [function({ value, seriesIndex, w }) {
          if(value > output.lbo_goal) {
              return '#dc3545'
          } else {
              return '#0d6efd'
          }
        }]
      },                  
      labels: output.lbo_style[0].label,
      xaxis: {}
    };
    chartStyle.updateOptions(options);

    //CHART DEFECT PPM
    options = {
      series: [
        {name: 'Actual', type: 'column', data: output.lbo_defectName[0].actual}, 
        {name: 'Goal', type: 'line', data: output.lbo_defectName[0].goal}
      ],
      chart: {height: 350, type: 'bar'},
      stroke: {width: [0, 4]},
      title: {text: 'Name of defect (PPM)'},
      dataLabels: {
        enabled: true, 
        enabledOnSeries: [0],
        formatter: function (val, opts) {
          return formatNumber(val);
        }
      },
      fill: {
        colors: [function({ value, seriesIndex, w }) {
          if(value > output.lbo_goal) {
              return '#dc3545'
          } else {
              return '#0d6efd'
          }
        }]
      },
      labels: output.lbo_defectName[0].label,
      xaxis: {}
    };
    chartDefectPpm.updateOptions(options);
    
    document.getElementById("icon-filter").classList.remove('spinner-border', 'spinner-border-sm');
    document.getElementById("icon-filter").classList.add('fa', 'fa-filter');

  } catch (error) {
    console.log(error);
  }
}