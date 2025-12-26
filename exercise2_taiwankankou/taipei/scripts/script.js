'use strict';

// モーダルウィンドウ処理
// ボタンとモーダル要素を取得し、モーダル内容を書き換える
const modalA = document.getElementById('modalBtnArea');
const modalButtons = modalA.querySelectorAll('button');

modalButtons.forEach(button => {
  button.addEventListener('click', (event) => {
    const buttonValue = event.target.value;
    console.log('クリックされたボタンの値:', buttonValue);
    // 必要に応じてbuttonValueを使った処理を記述
	const hours = ['17:00 - 25:00', '17:00 - 23:00', '16:00 - 00:00', '17:00 - 24:00'];
	let num;
	let hour;
    switch(buttonValue) {
        case '1':
            document.getElementById('modal1').textContent = '寧夏夜市';
            document.getElementById('modal2').src = 'images/Ningxia.png';
            document.getElementById('modal3').textContent = '寧夏路夜市は台湾伝統の屋台料理やB級グルメがメインの夜市です。特に大同区の圓環付近には懐かしいグルメがたくさん集まっていますので、思う存分味わってください。また、ここの夜市は歩道と車道が分かれているので、食事やショッピングに便利です。食の夜市とも言われる寧夏路夜市には毎日、大勢の人々が訪れています。';
			num = Number(buttonValue)-1;
			hour = hours[num];
			document.querySelectorAll(".modalHour").forEach(span => {
				span.textContent = hour;
			});
            break;
        case '2':
            document.getElementById('modal1').textContent = '饒河街観光夜市';
            document.getElementById('modal2').src = 'images/Gyouga.png';
            document.getElementById('modal3').textContent = '饒河街観光夜市は、屋台料理から雑貨や生活用品も扱う夜市です。その手ごろな値段が魅力的で、多くの人々で賑わいます。最も観光客に人気があるのは「藥燉排骨」「胡椒餅」「水煎包」「蚵仔麵線」など行列ができる人気料理と、「麻辣臭豆腐」「牛肉麵」「天婦羅」など台湾の伝統的な屋台料理も定番です。';
			num = Number(buttonValue)-1;
			hour = hours[num];
			document.querySelectorAll(".modalHour").forEach(span => {
				span.textContent = hour;
			});
            break;
        case '3':
            document.getElementById('modal1').textContent = '士林夜市';
            document.getElementById('modal2').src = 'images/shilin.png';
            document.getElementById('modal3').textContent = 'ここは市内で最も規模が大きく知名度の高い夜市で、台湾のおいしい屋台グルメからユニークな雑貨まで、ありとあらゆるものが売られています。その種類の豊富さ、敷地の広さ、歴史、そして夜遊びスポットとしての人気度と、士林夜市の魅力は何から何まで台北ナンバーワン。台北観光では絶対にはずせない魅惑スポットです。';
			num = Number(buttonValue)-1;
			hour = hours[num];
			document.querySelectorAll(".modalHour").forEach(span => {
				span.textContent = hour;
			});
            break;
        case '4':
            document.getElementById('modal1').textContent = '通化夜市';
            document.getElementById('modal2').src = 'images/Linjiang.png';
            document.getElementById('modal3').textContent = '台北の他の夜市と比べると小規模ではあるものの、食べ物においてはどの夜市にも決して劣りません。有名な駱記小炒(炒め物)、裕品元の氷火湯円、平価鉄板焼、通化夜市の揚げサツマイモボールは、ぜひとも賞味したい特色的な伝統軽食です。マッサージ店もたくさんあり、1日の終わりに最適な夜市です。';
			num = Number(buttonValue)-1;
			hour = hours[num];
			document.querySelectorAll(".modalHour").forEach(span => {
				span.textContent = hour;
			});
            break;
        default:
            console.log('終了処理');
            break;
    }
    // ボタンがクリックされたらモーダルを開く
    modal.style.display = 'block';
  });
});

// ボタンとモーダル要素を取得
let openBtn = document.getElementById('openModalBtn');
let modal = document.getElementById('myModal');
let closeBtn = document.getElementsByClassName('closeBtn')[0];

// バツ印がクリックされたらモーダルを閉じる
closeBtn.onclick = function() {
  modal.style.display = 'none';
}

// モーダルの外側がクリックされたらモーダルを閉じる
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
}