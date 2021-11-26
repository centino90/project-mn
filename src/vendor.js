import dayjs from 'dayjs'
window.dayjs = dayjs
dayjs().format()

var relativeTime = require('dayjs/plugin/relativeTime')
dayjs.extend(relativeTime)

import Alpine from 'alpinejs'
window.Alpine = Alpine

Alpine.start()