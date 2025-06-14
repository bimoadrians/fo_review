let header = `
<div class="row  ps-3 pt-2 pe-3 d-flex">
  <div class="col">
    <h3 class="mb-0" id="title">Production performance</h3>
    <p id="title-desc">Display production performance for spesifik periode</p>
  </div>
  <div class="col">

  </div>
</div>
<!-- filter bar -->
<div class="row ps-3 pe-3">
<form action="#" name="filter-form" name="filter-form">
<div class="col" id="form-filter">
  <div class="row">
    <div class="col">
      <div class="border ps-1 d-flex justify-content-between">
        <span class="pt-1" id="filter-stat">Current period :</span> 
        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="collapse" data-bs-target="#filter-container" id="filter-button">
          Clik to show or hide filter <span class="fas fa-angle-right"></span>
        </button>
      </div>
    </div>
  </div>
  <div class="row collapse mt-2 pe-3 align-items-center show" id="filter-container">
    <div class="col-sm pe-0">
      <div class="form-floating" id="display-period">
        <select class="form-select form-select-sm" id="period" name="period">
          <option>Daily</option>
          <option>Weekly</option>
          <option>Monthly</option>
          <option>Yearly</option>
        </select>
        <label for="period">Period :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <div class="form-floating d-none" id="display-year">`;
let curYear = new Date().getFullYear();
let dataYear ="";
header += `<select class="form-select form-select-sm" id="date-year" name="date-year">`;
  for (let i = curYear; i > 2020; i--) {
    header += `<option value="${i}">${i}</option>`;
  }
header += `</select>`;
header += `<label for="date-year">Year :</label>`;
header += `
      </div>
      <div class="form-floating" id="display-daily-from">
        <input type="text" class="form-control form-control-sm" id="date-from" placeholder="From :" value="" name="date-from">
        <label for="date-from">From :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <div class="form-floating d-none" id="display-week">`;

let endDate = new Date(curYear, 11, 31);
let incWeek = 0;
header += `<select class="form-select form-select-sm" id="date-week" name="date-week">`;
for (let curDate = new Date(curYear, 0, 1); curDate <= endDate; curDate.setDate(curDate.getDate() + 1)) {
  if (curDate.getDay() == 6) {
    let we = ((incWeek + 1) < 10 ? '0' + (incWeek + 1) : (incWeek + 1));
    let wm = ((curDate.getMonth() + 1) < 10 ? '0' + (curDate.getMonth() + 1) : (curDate.getMonth()+ 1));
    let wd = (curDate.getDate() < 10 ? '0' + curDate.getDate() : curDate.getDate());
    header += '<option value="' + wm + '/' + wd + '">WE ' + we + ' - ' + wm + '/' + wd +'</option>';
    incWeek = incWeek + 1;
  }
}
header += `</select>`;
header += `<label for="date-week">Week :</label>`;
header +=`
      </div>
      <div class="form-floating d-none" id="display-month">
        <select class="form-select form-select-sm" id="date-month" name="date-month">
          <option value="01">Januari</option>
          <option value="02">Februari</option>
          <option value="03">Maret</option>
          <option value="04">April</option>
          <option value="06">Mei</option>
          <option value="06">Juni</option>
          <option value="07">Juli</option>
          <option value="08">Agustus</option>
          <option value="09">September</option>
          <option value="10">Oktober</option>
          <option value="11">November</option>
          <option value="12">Desember</option>
        </select>
        <label for="date-month">Month :</label>
      </div>
      <div class="form-floating" id="display-daily-to">
        <input type="text" class="form-control form-control-sm" id="date-to" placeholder="To :" value="" name="date-to">
        <label for="date-to">To :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <div class="form-floating">
        <select class="form-select form-select-sm" id="unit" name="unit">
          <option value="ALL" selected>All</option>
          <option value="A">Mattel A</option>
          <option value="B">Mattel B</option>
        </select>
        <label for="unit">Unit :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <div class="form-floating">
        <select class="form-select form-select-sm" id="line" name="line">
          <option value="ALL" selected>All</option>
          <option value="08">Line 1</option>
          <option value="B">Line 2</option>
        </select>
        <label for="line">Line :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <div class="form-floating">
        <input type="text" class="form-control form-control-sm" id="style" placeholder="From :" value="" name="style">
        <label for="style">Style :</label>
      </div>
    </div>
    <div class="col-sm pe-0">
      <input class="form-check-input" type="checkbox" name="auto-refresh" id="auto-refresh" value="">
      <label class="form-check-label" for="auto-refresh">
        auto refresh
      </label>

      <button class="btn btn-sm btn-outline-dark" type="button" name="apply-filter" id="apply-filter">
         <span class="fa fa-filter"></span> Apply filter
      </button>
    </div>
  </div>
</div>
</form>
</div>
`;

export function showHeader(){
  return header;
}