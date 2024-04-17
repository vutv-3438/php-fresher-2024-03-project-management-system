/* global countIssueWithIssueTypeUrl, countIssueWithIssueTypeByMemberUrl */

import {Chart} from "chart.js";

function stringToColor(str)
{
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }

    const hue = Math.abs(hash % 360);
    const saturation = 50;
    const lightness = 70;
    const alpha = 0.7;
    return `hsla(${hue}, ${saturation}%, ${lightness}%, ${alpha})`;
}

window.renderCountIssueWithIssueType = function (url) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            let issueTypes = data;
            let backgroundColors = [];

            issueTypes.forEach(item => {
                let color = stringToColor(item.label);
                backgroundColors.push(color);
            });

            const ISSUE_TYPE_CHART = document.getElementById('issueTypeChart').getContext('2d');
            new Chart(ISSUE_TYPE_CHART, {
                type: 'pie',
                data: {
                    labels: issueTypes.map(item => item.label),
                    datasets: [{
                        label: 'Issue Type',
                        data: issueTypes.map(item => item.data),
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        })
        .catch(error => {
        });
}

window.renderCountIssueWithIssueTypeByMember = function (url) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const ISSUE_BY_MEMBER_CHART = document.getElementById('issueByMemberChart').getContext('2d');
            new Chart(ISSUE_BY_MEMBER_CHART, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        })
        .catch(error => {
        });
}
