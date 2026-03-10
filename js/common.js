    var ctx = document.getElementById("myRadarChart").getContext('2d');
    var myRadarChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels:  ["2021年", "2022年", "2023年", "2024年", "2025年"],  // Ｘ軸のラベル
            datasets: [
                {
                    label: "身長",                            // 系列名
                    data: [130, 132,  135, 135, 140],                 // 系列Ａのデータ
                    backgroundColor: "red",                      // 系列Ａの棒の色
		    yAxisID: "yaxis1",
                },
                {
                    label: "全国平均",                            // 系列名
                    data: [128, 130,  133, 133, 138],                 // 系列Ａのデータ
                    backgroundColor: "#aaa",                     // 系列Ａの棒の色
                    borderColor: "red",                     // 系列Ａの棒の色
                    borderWidth: 1,
		    yAxisID: "yaxis1"
                },
                {
                    label: "体重",                            // 系列名
                    data: [20, 22,  23, 25, 26],                 // 系列Ａのデータ
                    backgroundColor: "blue",                      // 系列Ａの棒の色
		    yAxisID: "yaxis2",
                },
                {
                    label: "全国平均",                            // 系列名
                    data: [18, 19,  21, 23, 24],                 // 系列Ａのデータ
                    backgroundColor: "#aaa",                      // 系列Ａの棒の色
                    borderColor: "blue",                     // 系列Ａの棒の色
                    borderWidth: 1,
		    yAxisID: "yaxis2"
                }
            ]
        },
        options: {
            responsive: true,  // canvasサイズ自動設定機能を使わない。HTMLで指定したサイズに固定
            title: {                 // 図のタイトル表示
                display: true,
                fontSize: 20,
                text: "複系列棒グラフ"
            },
/*
            legend: {                // 凡例の表示位置
                position: 'right'
            },                
*/
            scales: {
/*
                xAxes: [
                    {
                        stacked: true,  // 積み上げの指定
			barPercentage: 1.0,           //棒グラフ幅
			categoryPercentage: 0.4      //棒グラフ幅
                    }
                ],
*/
                yaxis1: {
			type: "linear",
			position: "left",
			title: {                 // 図のタイトル表示
				display: true,
				fontSize: 20,
				text: "身長"
			},
                        // ticks: { min: 0 }
                    },
                yaxis2: {
			type: "linear",
			position: "right",
			title: {                 // 図のタイトル表示
				display: true,
				fontSize: 20,
				text: "体重"
			},
                        // ticks: { min: 0 }
                    }
                }
            }
    });

var ctx = document.getElementById("myRadarChart3");
    var myRadarChart3 = new Chart(ctx, {
    //グラフの種類
          type: 'radar',
    //データの設定
      　　data: {
          labels: ['5-10-5Mｱｼﾞﾘﾃｨ走', '20M走', '身長', '体重', '5Mﾘｱｸｼｮﾝ走'],
          datasets: [
		  {
            label: '1回目',
	    //グラフのデータ
            data: [84, 60, 90, 90, 50],
            // データライン
            borderColor: 'red',
          },
		  {
            label: '2回目',
	    //グラフのデータ
            data: [87, 70, 95, 98, 50],
            // データライン
            borderColor: 'orange',
          },
		  {
            label: '3回目',
	    //グラフのデータ
            data: [90, 74, 95, 100, 56],
            // データライン
            borderColor: 'skyblue',
          },
		  {
            label: 'CASQ平均',
	    //グラフのデータ
            data: [80, 64, 95, 90, 36],
            // データライン
            borderColor: 'gray',
          }
	  ],

        },
        options: {
          scales: {
            r: {
              //グラフの最小値・最大値
              min: 0,
              max: 100,
              //背景色
              backgroundColor: 'snow',
              //グリッドライン
              grid: {
                color: 'pink',
              },
              //アングルライン
              angleLines: {
                color: 'green',
              },
              //ポイントラベル
              pointLabels: {
                color: 'blue',
              },
            },
          },
        }, 
      });
