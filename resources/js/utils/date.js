export function formatDate(value, format = 'd F Y') {
  if (!value) return '-'
  const d = new Date(value)
  if (isNaN(d.getTime())) return '-'

  const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
  const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

  const map = {
    l: days[d.getDay()],
    D: days[d.getDay()].slice(0, 3),
    d: String(d.getDate()).padStart(2, '0'),
    j: d.getDate(),
    F: months[d.getMonth()],
    M: months[d.getMonth()].slice(0, 3),
    m: String(d.getMonth() + 1).padStart(2, '0'),
    n: d.getMonth() + 1,
    Y: d.getFullYear(),
    y: String(d.getFullYear()).slice(-2),
    H: String(d.getHours()).padStart(2, '0'),
    i: String(d.getMinutes()).padStart(2, '0'),
    s: String(d.getSeconds()).padStart(2, '0'),
  }

  return format.replace(/[lDdjFMmnYyHis]/g, c => map[c] || c)
}

export function timeAgo(value) {
  if (!value) return ''
  const diff = Date.now() - new Date(value).getTime()
  const mins = Math.floor(diff / 60000)
  if (mins < 1) return 'just now'
  if (mins < 60) return mins + 'm ago'
  const hrs = Math.floor(mins / 60)
  if (hrs < 24) return hrs + 'h ago'
  return formatDate(value, 'd M Y')
}
