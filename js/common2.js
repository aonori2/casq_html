var ctx = document.getElementById("myRadarChart2");
    var myRadarChart = new Chart(ctx, {
    //グラフの種類
          type: 'radar',
    //データの設定
      　　data: {
          labels: ['5-10-5Mｱｼﾞﾘﾃｨ走', '20M走', '5Mﾘｱｸｼｮﾝ走', '立ち幅跳び', '垂直飛び'],
          datasets: [
		  {
            label: '1回目',
	    //グラフのデータ
            data: [84, 60, 50, 80, 70],
            // データライン
            borderColor: 'red',
          },
		  {
            label: '2回目',
	    //グラフのデータ
            data: [87, 70, 50, 82, 72],
            // データライン
            borderColor: 'orange',
          },
		  {
            label: '3回目',
	    //グラフのデータ
            data: [90, 74, 56, 83, 73],
            // データライン
            borderColor: 'skyblue',
          },
		  {
            label: 'CASQ平均',
	    //グラフのデータ
            data: [80, 64, 36, 90, 77],
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
