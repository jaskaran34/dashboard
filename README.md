# Project Overview

This project, built with **Laravel 11** and **Chart.js**, visualizes key analyses through five dynamic charts. Each chart provides insight into various sectors and analyses, making data exploration intuitive and interactive.

## Charts Included

1. **Sector Analysis** (Bar Chart)
2. **PESTLE Analysis** (Line Chart)
3. **SWOT Analysis** (Doughnut Chart)
4. **Impact Analysis** (Stacked Bar Chart: High, Medium, Low)
5. **Impact, Relevance, and Topic Count** (Stacked Radar Chart across different sectors)

## Features

- **Dynamic Filtering**: All charts respond dynamically to the following common filters:
  - `end_year`
  - `region`
  - `relevance`
  - `intensity`

- **Sector Analysis Chart Filters**:
  - Modify the total number of records displayed (defaults to top 5 sectors)
  - Filter by `impact` level

- **Interactive Modal**: Clicking on a bar in the Sector Analysis chart opens a modal displaying detailed information about that sector.

![Screenshot](./public/Screenshot%202024-09-30%20025818.png)