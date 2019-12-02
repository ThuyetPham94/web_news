// set function parseTime,formatTime to filter
export { parseTime, formatTime, addClass, removeClass } from '@/utils';

export function pluralize(time, label) {
  if (time === 1) {
    return time + label;
  }
  return time + label + 's';
}

export function timeAgo(time) {
  const between = Date.now() / 1000 - Number(time);
  if (between < 3600) {
    return pluralize(~~(between / 60), ' minute');
  } else if (between < 86400) {
    return pluralize(~~(between / 3600), ' hour');
  } else {
    return pluralize(~~(between / 86400), ' day');
  }
}

/* Number formating*/
export function numberFormatter(num, digits) {
  const si = [
    { value: 1E18, symbol: 'E' },
    { value: 1E15, symbol: 'P' },
    { value: 1E12, symbol: 'T' },
    { value: 1E9, symbol: 'G' },
    { value: 1E6, symbol: 'M' },
    { value: 1E3, symbol: 'k' },
  ];
  for (let i = 0; i < si.length; i++) {
    if (num >= si[i].value) {
      return (num / si[i].value + 0.1).toFixed(digits).replace(/\.0+$|(\.[0-9]*[1-9])0+$/, '$1') + si[i].symbol;
    }
  }
  return num.toString();
}

export function toThousandFilter(num) {
  return (+num || 0).toString().replace(/^-?\d+/g, m => m.replace(/(?=(?!\b)(\d{3})+$)/g, ','));
}

export function getRole(role) {
  if (role === 'waiter') {
    return 'Nhân viên bồi bàn';
  } else if (role === 'chef') {
    return 'Nhân viên bếp';
  } else if (role === 'cashier') {
    return 'Nhân viên thu ngân';
  }
}

export function filterSex(sex) {
  if (sex === 0) {
    return 'Nam';
  } else if (sex === 1) {
    return 'Nữ';
  }
}

// chỉnh lại date range cho xuyên suốt và thời vụ
export function filterDay(days, dateFrom, dateTo, type) {
  console.log(type, '=type=');
  if (type === true) {
    if (days.length === 7) {
      return 'Các ngày trong tuần';
    }
    return days.join(' - ') + ' hàng tuần';
  } else {
    return dateFrom + ' - ' + dateTo;
  }
}
