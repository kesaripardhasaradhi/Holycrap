fetch('/controlPage/apis/total')
  .then(res => res.json())
  .then(({ Accounts, Clicks, Visits }) => {
    Object.assign(document.getElementById('totalAccounts'), { textContent: Accounts });
    Object.assign(document.getElementById('totalClicks'), { textContent: Clicks });
    Object.assign(document.getElementById('totalVisits'), { textContent: Visits });
  });
fetch('/backend/apis/data')
  .then(res => res.json())
  .then(data => {
    const summary = data.summary ?? 0;
    const rap = data.rap ?? 0;
    const robux = data.robux ?? 0;

    document.getElementById('thingy').textContent = `${summary} | ${rap} | ${robux}`;
  })
  .catch(error => {
    console.error('Error @', error);
  });
document.addEventListener('DOMContentLoaded', function () {
  const _0x402b0d = document.getElementById('dashboard-option')
  const _0x1284a4 = document.getElementById('dashboard-container')
  _0x402b0d.classList.add('active')
  _0x1284a4.classList.add('active')
  const _0x438804 = document.getElementById('leaderboard-tab')
  const _0x38b311 = document.getElementById('recent-hits-tab')
  const _0x56c7ce = document.getElementById('leaderboard')
  const _0x596d59 = document.getElementById('recent-hits')
  _0x56c7ce.style.display = 'block'
  _0x438804.classList.add('leaderboard-option-active')
  _0x38b311.addEventListener('click', function () {
    _0x596d59.style.display = 'block'
    _0x56c7ce.style.display = 'none'
    _0x38b311.classList.add('leaderboard-option-active')
    _0x438804.classList.remove('leaderboard-option-active')
  })
  _0x438804.addEventListener('click', function () {
    _0x56c7ce.style.display = 'block'
    _0x596d59.style.display = 'none'
    _0x438804.classList.add('leaderboard-option-active')
    _0x38b311.classList.remove('leaderboard-option-active')
  })
  const _0x155acd = document.querySelectorAll('.sidebar-option')
  const _0x18f2ab = document.querySelectorAll('.container')
  const _0x1d150a = document.querySelectorAll('.sidebar-modal-content-item')
  function _0x1dd5f2(_0x15f0d4) {
    _0x155acd.forEach((_0x8a5413) => _0x8a5413.classList.remove('active'))
    _0x155acd[_0x15f0d4].classList.add('active')
    _0x18f2ab.forEach((_0x18e87b) => (_0x18e87b.style.display = 'none'))
    _0x18f2ab[_0x15f0d4].style.display = 'block'
    localStorage.setItem('activeOptionIndex', _0x15f0d4)
  }
  const _0x4f7eb3 = localStorage.getItem('activeOptionIndex')
  if (_0x4f7eb3 !== null) {
    _0x1dd5f2(parseInt(_0x4f7eb3))
  }
  _0x155acd.forEach((_0x2f6187, _0x2bb27a) => {
    _0x2f6187.addEventListener('click', () => {
      _0x1dd5f2(_0x2bb27a)
    })
  })
  function _0x56b032(_0x1c39ed) {
    _0x18f2ab.forEach((_0x118998) => (_0x118998.style.display = 'none'))
    _0x18f2ab[_0x1c39ed].style.display = 'block'
    localStorage.setItem('activeOptionIndex', _0x1c39ed)
    document.getElementById('sidebar-modal-container').style.display = 'none'
  }
  if (_0x4f7eb3 !== null) {
    _0x56b032(parseInt(_0x4f7eb3))
  }
  _0x1d150a.forEach((_0x9a0b0f, _0x455096) => {
    _0x9a0b0f.addEventListener('click', () => {
      _0x56b032(_0x455096)
    })
  })
  let _0x54992e = [10, 20, 30, 0, 50, 0, 70]
  let _0x3faed8 = [10, 40, 20, 0, 0, 10, 80]
  let _0x556e88 = [0, 0, 0, 0, 0, 0, 0]
  function _0x13fc7c(_0x489312, _0xef41aa, _0x3ad950) {
    const _0x1f3075 = document.querySelector('.canvas')
    const _0x71ffde = _0x1f3075.clientWidth
    const _0x5b7be3 = _0xef41aa.length
    const _0x2a48ab = _0x71ffde - 10 * (_0x5b7be3 - 1)
    const _0x369c52 = _0x2a48ab / _0x5b7be3
    const _0x22cb6f = (_0x369c52 / _0x71ffde) * 0.9
    const _0x5c6295 = document.getElementById(_0x489312).getContext('2d')
    new Chart(_0x5c6295, {
      type: 'bar',
      data: {
        labels: [
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
          'Sunday',
        ],
        datasets: [
          {
            label: _0x3ad950,
            data: _0xef41aa,
            backgroundColor: '#57BA82',
            minBarLength: 4,
            barThickness: _0x369c52,
          },
        ],
      },
      options: {
        scales: {
          x: { display: false },
          y: { display: false },
        },
        plugins: { legend: { display: false } },
        responsive: true,
        maintainAspectRatio: false,
        barPercentage: _0x22cb6f,
        categoryPercentage: 1,
      },
    })
  }
  makeRequest('/backend/apis/accounts', 'GET', null, [0, 0, 0, 0, 0, 0, 0])
    .then((_0x2215b4) => {
      var _0x32e02b = new Date()
      var _0xdbe95e = (_0x32e02b.getDay() + 6) % 7
      document.getElementById('Accounts-increase').innerHTML =
        '+' + _0x2215b4[_0xdbe95e] + ' Today'
      var _0x19975f = Math.round(
        ((_0x2215b4[_0xdbe95e] - _0x2215b4[_0xdbe95e - 1]) /
          _0x2215b4[_0xdbe95e - 1]) *
          100
      )
      if (isNaN(_0x19975f)) {
        _0x19975f = 0
      }
      if (!isFinite(_0x19975f)) {
        _0x19975f = 'Inf'
      }
      document.getElementById('accounts-Percentage').innerHTML = _0x19975f + '%'
      _0x13fc7c('chart1', _0x2215b4, 'Accounts')
      makeRequest('/backend/apis/visits', 'GET', null, [0, 0, 0, 0, 0, 0, 0])
        .then((_0x266cb6) => {
          var _0x13841c = new Date()
          var _0x44279a = (_0x13841c.getDay() + 6) % 7
          document.getElementById('LinkVisit-increase').innerHTML =
            '+' + _0x266cb6[_0x44279a] + ' Today'
          var _0x275118 = Math.round(
            ((_0x266cb6[_0x44279a] - _0x266cb6[_0x44279a - 1]) /
              _0x266cb6[_0x44279a - 1]) *
              100
          )
          if (isNaN(_0x275118)) {
            _0x275118 = 0
          }
          if (!isFinite(_0x275118)) {
            _0x275118 = 'Inf'
          }
          document.getElementById('link-Percentage').innerHTML = _0x275118 + '%'
          _0x13fc7c('chart2', _0x266cb6, 'Visits')
          makeRequest('/backend/apis/clicks', 'GET', null, [0, 0, 0, 0, 0, 0, 0])
            .then((_0x4a9af2) => {
              var _0x4e4396 = new Date()
              var _0x441d52 = (_0x4e4396.getDay() + 6) % 7
              document.getElementById('Clicks-increase').innerHTML =
                '+' + _0x4a9af2[_0x441d52] + ' Today'
              var _0x1e8e07 = Math.round(
                ((_0x4a9af2[_0x441d52] - _0x4a9af2[_0x441d52 - 1]) /
                  _0x4a9af2[_0x441d52 - 1]) *
                  100
              )
              if (isNaN(_0x1e8e07)) {
                _0x1e8e07 = 0
              }
              if (!isFinite(_0x1e8e07)) {
                _0x1e8e07 = 'Inf'
              }
              document.getElementById('login-Percentage').innerHTML =
                _0x1e8e07 + '%'
              _0x13fc7c('chart3', _0x4a9af2, 'Clicks')
              createLineChart(_0x266cb6, _0x2215b4, _0x4a9af2)
            })
            .catch((_0x2a1731) => {
              console.error('Error fetching data:', _0x2a1731)
            })
        })
        .catch((_0x97dc07) => {
          console.error('Error fetching data:', _0x97dc07)
        })
    })
    .catch((_0x15aaea) => {
      console.error('Error fetching data:', _0x15aaea)
    })
  setTimeout(function () {
    makeRequest('apis/myHits', 'GET', null, [])
      .then((_0x6cdb12) => {
        updateTable(_0x6cdb12)
      })
      .catch((_0x1ce277) => {
        console.error('Error fetching data:', _0x1ce277)
      })
  }, 1000)
  function _0x19517f() {
    const _0x8cf0bd = document.querySelectorAll('.rowCheckbox:checked')
    if (_0x8cf0bd.length === 0) {
      return
    }
    let _0x168c6b = 'Username / Password / Balance / Summary / Rap\n'
    _0x8cf0bd.forEach((_0xb1ce04) => {
      const _0x2ffd19 = Array.from(
        _0xb1ce04.parentElement.parentElement.children
      )
        .slice(1)
        .map((_0x794107) => _0x794107.textContent.trim())
        .join(' / ')
      _0x168c6b += _0x2ffd19 + '\n'
    })
    const _0x18904b = new Blob([_0x168c6b], { type: 'text/plain' })
    const _0x191eb3 = document.createElement('a')
    _0x191eb3.href = URL.createObjectURL(_0x18904b)
    _0x191eb3.download = 'users.txt'
    _0x191eb3.click()
  }
  document.getElementById('downloadBtn').addEventListener('click', _0x19517f)
})
var sampleData = []
updateTable(sampleData)
function updateTable(_0xea3a32) {
  var _0x4a3f00 = _0xea3a32.length
  if (_0x4a3f00 === 0) {
    document.getElementById('tableBody').innerHTML =
      '<tr><td colspan="8" class="no-results">No results.</td></tr>'
  } else {
    var _0x503fb7 = document.getElementById('tableBody')
    _0x503fb7.innerHTML = ''
    _0xea3a32.forEach(function (_0x480422) {
      var _0x4d7f33 = document.createElement('tr')
      _0x4d7f33.style.borderBottom = '0.5px solid #27272b'
      var _0x5cb14c = document.createElement('td')
      var _0x105e20 = document.createElement('input')
      _0x105e20.type = 'checkbox'
      _0x105e20.className = 'rowCheckbox custom-checkbox'
      _0x5cb14c.appendChild(_0x105e20)
      _0x4d7f33.appendChild(_0x5cb14c)
      var _0x53fc60 = document.createElement('td')
      var _0x1c1d3a = document.createElement('div')
      _0x1c1d3a.style.display = 'flex'
      _0x1c1d3a.style.alignItems = 'center'
      var _0x4e6c = new Image()
      _0x4e6c.src = 'assets/icon-dark.webp'
      _0x4e6c.width = 24
      _0x4e6c.height = 24
      _0x4e6c.style.borderRadius = '50%'
      _0x4e6c.style.marginRight = '15px'
      _0x1c1d3a.appendChild(_0x4e6c)
      var _0x5d6eaa = document.createTextNode(_0x480422.username)
      _0x1c1d3a.appendChild(_0x5d6eaa)
      _0x53fc60.appendChild(_0x1c1d3a)
      _0x4d7f33.appendChild(_0x53fc60)
      var _0x371caa = document.createElement('td')
      _0x371caa.textContent = _0x480422.password
      _0x4d7f33.appendChild(_0x371caa)
      _0x4d7f33.appendChild(_0x371caa)
      var _0x5b5d29 = document.createElement('td')
      _0x5b5d29.textContent = _0x480422.summary
      _0x4d7f33.appendChild(_0x5b5d29)
      var _0x112694 = document.createElement('td')
      _0x112694.textContent = _0x480422.robux
      _0x4d7f33.appendChild(_0x112694)
      var _0x15d65e = document.createElement('td')
      _0x15d65e.textContent = _0x480422.rap
      _0x4d7f33.appendChild(_0x15d65e)
      var _0x237ab5 = document.createElement('td')
      _0x237ab5.textContent = _0x480422.date
      _0x4d7f33.appendChild(_0x237ab5)
      var _0xa86e19 = document.createElement('td')
      _0xa86e19.style.maxWidth = '5px'
      _0xa86e19.style.overflow = 'hidden'
      _0xa86e19.style.whiteSpace = 'nowrap'
      _0xa86e19.style.textOverflow = 'ellipsis'
      _0xa86e19.textContent = _0x480422.cookie
      _0xa86e19.addEventListener('click', function () {
        var _0x560817 = _0xa86e19.textContent.trim()
        var _0x3cba07 = document.createElement('input')
        document.body.appendChild(_0x3cba07)
        _0x3cba07.setAttribute('value', _0x560817)
        _0x3cba07.select()
        document.execCommand('copy')
        document.body.removeChild(_0x3cba07)
        alert('Copied Cookie')
      })
      _0x4d7f33.appendChild(_0xa86e19)
      _0x503fb7.appendChild(_0x4d7f33)
    })
  }
  updateHeaderCheckbox()
}
document
  .getElementById('dataTable')
  .addEventListener('change', function (_0x3b1a92) {
    if (_0x3b1a92.target && _0x3b1a92.target.matches('.rowCheckbox')) {
      updateHeaderCheckbox()
    }
  })
function updateHeaderCheckbox() {
  var _0x50f3f6 = document
    .getElementById('headerCheckbox')
    .getElementsByTagName('input')[0]
  var _0x192dc6 = document.getElementsByClassName('rowCheckbox')
  var _0x4ce33e = _0x192dc6.length
  var _0x90bcc6 = 0
  for (var _0x4ff1a5 = 0; _0x4ff1a5 < _0x4ce33e; _0x4ff1a5++) {
    if (_0x192dc6[_0x4ff1a5].checked) {
      _0x90bcc6++
    }
  }
  if (_0x90bcc6 === 0) {
    _0x50f3f6.checked = false
    _0x50f3f6.indeterminate = false
    document.querySelector('.total-rows').textContent =
      '0 of ' + _0x4ce33e + ' row(s) selected.'
    document.getElementById('downloadBtn').classList.remove('active-download')
    document.getElementById('downloadBtn').classList.add('download')
  } else {
    if (_0x90bcc6 === _0x4ce33e) {
      _0x50f3f6.checked = true
      _0x50f3f6.indeterminate = false
      document.querySelector('.total-rows').textContent =
        _0x4ce33e + ' of ' + _0x4ce33e + ' row(s) selected.'
      document.getElementById('downloadBtn').classList.add('active-download')
      document.getElementById('downloadBtn').classList.remove('download')
    } else {
      _0x50f3f6.checked = false
      _0x50f3f6.indeterminate = true
      document.querySelector('.total-rows').textContent =
        _0x90bcc6 + ' of ' + _0x4ce33e + ' row(s) selected.'
      document.getElementById('downloadBtn').classList.add('active-download')
      document.getElementById('downloadBtn').classList.remove('download')
    }
  }
}
function toggleAllCheckboxes(_0x3e3f08) {
  var _0x5b82ad = document.getElementsByClassName('rowCheckbox')
  var _0x569553 = _0x5b82ad.length
  for (var _0x4250e0 = 0; _0x4250e0 < _0x569553; _0x4250e0++) {
    _0x5b82ad[_0x4250e0].checked = _0x3e3f08.checked
    document.querySelector('.total-rows').textContent =
      '0 of ' + _0x4250e0 + ' row(s) selected.'
  }
  updateHeaderCheckbox()
}
const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
function createLineChart(_0x34a4b0, _0x42ce2a, _0x49fdf1) {
  const _0x4c2d55 = document.getElementById('line-chart').getContext('2d')
  new Chart(_0x4c2d55, {
    type: 'line',
    data: {
      labels: days,
      datasets: [
        {
          label: 'LinkVisits',
          data: _0x34a4b0,
          borderColor: '#852629',
          fill: true,
          tension: 0.4,
        },
        {
          label: 'Hits',
          data: _0x42ce2a,
          borderColor: '#693F84',
          fill: true,
          tension: 0.4,
        },
        {
          label: 'ButtonClicks',
          data: _0x49fdf1,
          borderColor: '#4FB3BD',
          fill: true,
          tension: 0.4,
        },
      ],
    },
    options: {
      scales: {
        x: {
          display: true,
          title: { display: true },
        },
        y: {
          display: true,
          title: { display: true },
          ticks: {
            stepSize: 100,
            beginAtZero: true,
          },
        },
      },
      plugins: {
        tooltip: {
          mode: 'index',
          intersect: false,
        },
        legend: {
          display: true,
          labels: { usePointStyle: true },
          legendItem: function (_0x38f0ac) {
            const _0x2450fc = getIconForLabel(_0x38f0ac.text)
            const _0x3fa2e7 = _0x38f0ac.text
            const _0x19b2e7 =
              '<img src="' +
              _0x2450fc +
              '" style="vertical-align: middle; margin-right: 5px;"> ' +
              _0x3fa2e7
            return { text: _0x19b2e7 }
          },
        },
      },
    },
    plugins: [
      {
        afterInit: function (_0x292a76, _0x52c9ed, _0x439b76) {
          var _0x13dad0 = _0x292a76.tooltip.getTooltipPosition
          _0x292a76.tooltip.getTooltipPosition = function (
            _0x259cea,
            _0x3bd438
          ) {
            var _0x246169 = _0x13dad0.call(this, _0x259cea, _0x3bd438)
            _0x246169.x = _0x292a76.scales.x.getValueForPixel(_0x3bd438.x)
            return _0x246169
          }
        },
      },
    ],
  })
}
function getIconForLabel(_0x46312c) {
  const _0xe4a090 = {
    Visits: '/controlPage/assets/icons8-eye-16.png',
    Hits: '/controlPage/assets/mouse.png',
    Clicks: '/controlPage/assets/pulse.png',
  }
  return _0xe4a090[_0x46312c] || ''
}
function toggleDropdown() {
  document.getElementById('myDropdown').classList.toggle('show')
}
window.onclick = function (_0x1955af) {
  if (!_0x1955af.target.matches('.dropbtn')) {
    var _0x207ed2 = document.getElementsByClassName('dropdown-content')
    var _0x58dab4
    for (_0x58dab4 = 0; _0x58dab4 < _0x207ed2.length; _0x58dab4++) {
      var _0x2f7162 = _0x207ed2[_0x58dab4]
      if (_0x2f7162.classList.contains('show')) {
        _0x2f7162.classList.remove('show')
      }
    }
  }
}
let indexWithOption = 0
function updateFilter(_0x56bb0f) {
  const _0x5d1f3c = document.getElementById('dropdown-filter-title')
  indexWithOption = 0
  _0x5d1f3c.textContent = _0x56bb0f
  if (_0x56bb0f == 'Show All') {
    limit = 99999999
  } else {
    limit = 10
  }
  toggleDropdown()
  const _0x3cc2e7 =
    'apis/beta/myHits?option=' +
    _0x56bb0f +
    '&startIndex=' +
    indexWithOption +
    '&limit=' +
    limit
  makeRequest(_0x3cc2e7, 'GET', null, [])
    .then((_0x3afeb3) => {
      updateTable(_0x3afeb3)
    })
    .catch((_0x4c23a5) => {
      console.error('Error fetching data:', _0x4c23a5)
    })
}
var profileIcon = document.getElementById('profile-icon')
var modal = document.getElementById('profile-modal')
var usernameElement = document.querySelector('.username')
var emailElement = document.querySelector('.email')
var logoutElement = document.querySelector('.logout')
function openProfileModal() {
  if (modal.style.display === 'block') {
    modal.style.display = 'none'
  } else {
    modal.style.display = 'block'
  }
}
function closeProfileModal() {
  modal.style.display = 'none'
}
profileIcon.onclick = openProfileModal
usernameElement.onclick = closeProfileModal
emailElement.onclick = closeProfileModal
logoutElement.onclick = closeProfileModal
window.onclick = function (_0x56a889) {
  if (_0x56a889.target == modal) {
    closeProfileModal()
  }
}
function toggleStatusDropdown(_0x40a67c) {
  var _0x112fbe = _0x40a67c.nextElementSibling
  _0x112fbe.classList.toggle('show')
}
window.onclick = function (_0xa3b544) {
  if (!_0xa3b544.target.matches('.status-dropbtn')) {
    var _0xe0ba19 = document.querySelectorAll('.status-dropdown-content')
    _0xe0ba19.forEach(function (_0x15bf85) {
      if (_0x15bf85.classList.contains('show')) {
        _0x15bf85.classList.remove('show')
      }
    })
  }
}
function updateStatus(_0x20cea1, _0xdfb08) {
  document.querySelector('#status-dropbtn-text').innerHTML = _0xdfb08
}
function togglePremiumDropdown(_0x3f36d7) {
  var _0x5f149a = _0x3f36d7.nextElementSibling
  _0x5f149a.classList.toggle('show')
}
window.onclick = function (_0x4be8a3) {
  if (!_0x4be8a3.target.matches('.premium-dropbtn')) {
    var _0x153056 = document.querySelectorAll('.premium-dropdown-content')
    _0x153056.forEach(function (_0xa05f32) {
      if (_0xa05f32.classList.contains('show')) {
        _0xa05f32.classList.remove('show')
      }
    })
  }
}
function updatePremium(_0x33afe3, _0x30195d) {
  document.querySelector('#premium-dropbtn-text').innerHTML = _0x30195d
}
function updateVisitNotif(_0x5e433f, _0x18cce7) {
  document.querySelector('#visitnoti').innerHTML = _0x18cce7
}
function openModal() {
  document.getElementById('modal-container').style.display = 'block'
}
function closeModal() {
  document.getElementById('modal-container').style.display = 'none'
}
window.onclick = function (_0x26a272) {
  var _0x12c788 = document.getElementById('modal-container')
  if (_0x26a272.target == _0x12c788) {
    _0x12c788.style.display = 'none'
  }
}
function openSidebarModal() {
  document.getElementById('sidebar-modal-container').style.display = 'block'
}
function closeSidebarModal() {
  document.getElementById('sidebar-modal-container').style.display = 'none'
}
window.onclick = function (_0x56fa41) {
  var _0x2c214a = document.getElementById('sidebar-modal-container')
  if (_0x56fa41.target == _0x2c214a) {
    _0x2c214a.style.display = 'none'
  }
}
async function makeRequest(
  _0x4307bc,
  _0x481e08,
  _0xf5642b = null,
  _0x18aa92 = []
) {
  const _0x270d83 = {
    method: _0x481e08,
    headers: { 'Content-Type': 'application/json' },
  }
  if (_0xf5642b) {
    _0x270d83.body = JSON.stringify(_0xf5642b)
  }
  try {
    const _0x23941f = await fetch(_0x4307bc, _0x270d83)
    const _0x320980 = _0x23941f.headers.get('content-type')
    if (_0x320980 && _0x320980.includes('application/json')) {
      return await _0x23941f.json()
    } else {
      return await _0x23941f.text()
    }
  } catch (_0x351399) {
    console.error('Error:', _0x351399)
    return _0x18aa92
  }
}
function populateLeaderboard(_0x2600d6) {
  const _0x5b7a7e = document.getElementById('leaderboard')
  _0x5b7a7e.innerHTML = ''
  _0x2600d6.forEach((_0x3986b9) => {
    const _0x424a85 = document.createElement('div')
    _0x424a85.classList.add('user-profile-data-item')
    const _0x2b6ef5 = document.createElement('div')
    _0x2b6ef5.classList.add('profile-data')
    const _0x1afb36 = document.createElement('img')
    _0x1afb36.classList.add('item-img')
    _0x1afb36.src = _0x3986b9.profilePictureBlobURL
    _0x1afb36.alt = 'Profile Picture'
    const _0x1af88e = document.createElement('div')
    _0x1af88e.classList.add('user-name')
    _0x1af88e.textContent = _0x3986b9.username
    _0x2b6ef5.appendChild(_0x1afb36)
    _0x2b6ef5.appendChild(_0x1af88e)
    const _0x111196 = document.createElement('div')
    _0x111196.classList.add('profile-data')
    const _0x2eef63 = document.createElement('img')
    _0x2eef63.classList.add('item-img')
    _0x2eef63.src = '/controlPage/assets/hit-icon.png'
    _0x2eef63.alt = 'Hit Icon'
    const _0x38dc8a = document.createElement('div')
    _0x38dc8a.classList.add('user-name')
    _0x38dc8a.textContent = _0x3986b9.integerValue
    _0x111196.appendChild(_0x2eef63)
    _0x111196.appendChild(_0x38dc8a)
    _0x424a85.appendChild(_0x2b6ef5)
    _0x424a85.appendChild(_0x111196)
    _0x5b7a7e.appendChild(_0x424a85)
  })
}
makeRequest('apis/leaderboard', 'GET', null)
  .then((_0x2421b9) => {
    populateLeaderboard(_0x2421b9)
  })
  .catch((_0x1a7f4f) => {
    console.error('Error fetching data:', _0x1a7f4f)
  })
const currentTableIndex = 0
let limit = 10
document.querySelector('.previous').addEventListener('click', function () {
  if (indexWithOption == 0) {
    return
  }
  const _0x369f82 = document.getElementById('dropdown-filter-title').textContent
  let _0x5da863
  indexWithOption--
  _0x5da863 =
    'apis/beta/myHits?option=' +
    _0x369f82 +
    '&startIndex=' +
    indexWithOption +
    '&limit=' +
    limit
  makeRequest(_0x5da863, 'GET', null, [])
    .then((_0x1f7d08) => {
      updateTable(_0x1f7d08)
    })
    .catch((_0x4c42aa) => {
      console.error('Error fetching data:', _0x4c42aa)
    })
})
document.querySelector('.next').addEventListener('click', function () {
  const _0x5316fe = document.getElementById('dropdown-filter-title').textContent
  let _0x8501b0
  indexWithOption++
  _0x8501b0 =
    'apis/beta/myHits?option=' +
    _0x5316fe +
    '&startIndex=' +
    indexWithOption +
    '&limit=' +
    limit
  makeRequest(_0x8501b0, 'GET', null, [])
    .then((_0x452629) => {
      updateTable(_0x452629)
    })
    .catch((_0x407249) => {
      console.error('Error fetching data:', _0x407249)
    })
})
document.getElementById('other-save-changes').addEventListener('click', () => {
  const _0x40796d = {
    webhook: document.getElementById('webhook').value,
    avatar_url: document.getElementById('avatar_url').value,
    visitnoti: document.getElementById('visitnoti').innerHTML,
  }
  function _0x18a948() {}
  _0x18a948()
  makeRequest('apis/beta/formData', 'POST', { ..._0x40796d }, {}).then(
    (_0x47eacf) => {
      if (_0x47eacf.success) {
        location.reload()
      } else {
        PopupFail(_0x47eacf.errors[0].message)
      }
    }
  )
})
document
  .getElementById('group-form-save-changes')
  .addEventListener('click', () => {
    const _0x298af6 = {
      group_name: document.getElementById('group-name').value,
      group_owner: document.getElementById('group-owner').value,
      group_thumbnails: document.getElementById('group-thumbnail').value,
      group_funds: document.getElementById('group-funds').value,
      group_member: document.getElementById('group-members').value,
      group_shout: document.getElementById('group-shout').value,
      group_description: document.getElementById('group-desc').value,
    }
    function _0xd62d9f() {}
    _0xd62d9f()
    makeRequest('apis/beta/formData', 'POST', { ..._0x298af6 }, {}).then(
      (_0x48964f) => {
        if (_0x48964f.success) {
          location.reload()
        } else {
          PopupFail(_0x48964f.errors[0].message)
        }
      }
    )
  })
document
  .getElementById('normal-form-save-changes')
  .addEventListener('click', () => {
    const _0x21abfc = {
      profile_username: document.getElementById('real-username').value,
      profile_displayname: document.getElementById('fake-username').value,
      profile_premium: document.querySelector('#premium-dropbtn-text')
        .innerHTML,
      profile_friends: document.getElementById('normal-friends').value,
      profile_followers: document.getElementById('normal-followers').value,
      profile_followings: document.getElementById('normal-followings').value,
      profile_activity: document.querySelector('#status-dropbtn-text')
        .innerText,
      profile_created: document.getElementById('creation-date').value,
      profile_about: document.getElementById('normal-description').value,
    }
    function _0x3f8ef4() {}
    _0x3f8ef4()
    makeRequest('apis/beta/formData', 'POST', { ..._0x21abfc }, {}).then(
      (_0x36653c) => {
        if (_0x36653c.success) {
          location.reload()
        } else {
          PopupFail(_0x36653c.errors[0].message)
        }
      }
    )
  })
function PopupFail(_0x53a6b3) {
  Swal.fire({
    titleText: 'Error Saving Data',
    text: _0x53a6b3,
    icon: null,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    customClass: {
      popup: 'swal2-popup',
      title: 'swal2-title-fail',
      content: 'swal2-content',
    },
  })
}