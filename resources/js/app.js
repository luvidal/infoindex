import './bootstrap';
import '../css/app.css'

import jsVectorMap from 'jsvectormap'
import '../maps//world.js'
import '../maps/us.js'

import '../maps/europe.js'
import '../maps/uk.js'
import '../maps/france.js'
import '../maps/germany.js'

import '../maps/asia.js'
import '../maps/skorea.js'
import '../maps/china.js'

import '../maps/latam.js'


import { IndicesPerRegion, GetIndexInfo } from './main';
window.IndicesPerRegion = IndicesPerRegion;
window.GetIndexInfo = GetIndexInfo;

