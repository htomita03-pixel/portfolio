'use strict';

//スライダー全体
const slide = document.getElementById('slide');
//矢印
const prev = document.getElementById('prev');
const next = document.getElementById('next');
//インディケーター全体
const indicator = document.getElementById('indicator');
//インディケーターのドット部分(黒丸)
const lists = document.querySelectorAll('.list');
//スライダーの長さ(画像の枚数)
const totalSlides = lists.length;
//現在のインデックス番号の取得
let count = 2;
//自動再生用変数
let autoPlayInterval;

//初期位置
let slideWidth;
let startOffset;

function setSlideSize () {
  if (window.innerWidth >= 768) {
    //PC
    slideWidth = 375;                // 295 + 40*2
    startOffset = 490;
  } else {
    slideWidth = 315;                // 295 + 10*2
    startOffset = 30;
  }
}
function slidePos() {
  const moveX = -(slideWidth * count) + startOffset;
  slide.style.transform = `translateX(${moveX}px)`;
}
//初期化
setSlideSize();
slidePos();
updateListBackground();
window.addEventListener('resize', function () {
  slide.style.transition = 'none';
  setSlideSize();
  slidePos();
  updateListBackground();
});


//インディケーターのドット部分の色変更
function updateListBackground() {
  let activeIndex = count - 2;
  //ダミー対策(左・右)
  if (activeIndex < 0) {
    activeIndex = totalSlides - 2;
  }
  if (activeIndex >= totalSlides) {
    activeIndex = 0;
  }
  for (let i = 0; i < lists.length; i++) {
    if (i === activeIndex) {
      lists[i].style.backgroundColor = '#000000';
    } else {
      lists[i].style.backgroundColor = '#8F8F8F';
    };
  };
}


//nextクリックするとカウント1増える＆インディケーターのドット部分の色変更
function nextClick() {
  slide.style.transition = 'transform 0.6s ease';
  count++;
  slidePos();
  if (count === totalSlides + 2) {
    setTimeout(function () {
      slide.style.transition = 'none';
      count = 2;
      slidePos();
    }, 300);
  } else {
    updateListBackground();
  }
  updateListBackground();
}

function prevClick() {
  slide.style.transition = 'transform 0.6s ease';
  count--;
  slidePos();
  if (count === 0) {
    //一枚目表示
    //count = totalSlides - 1;
    setTimeout(function () {
      slide.style.transition = 'none';
      count = totalSlides;
      slidePos();
    }, 300);
  }
  updateListBackground();
}


//自動再生用のクリックファンクション  完全再利用可能
function startAutoPlay() {
  autoPlayInterval = setInterval(nextClick, 3000);
}

//インディケーター押されると自動再生用時間のリセットファンクション
function resetAutoPlayInterval() {
  clearInterval(autoPlayInterval);
  startAutoPlay();
}

//矢印クリック後の動き  アロー関数→理解できるファンクションの形に直す
next.addEventListener('click', function() {
  nextClick();
  resrtAutoPlayInterval();
});
prev.addEventListener('click', function() {
  prevClick();
  resrtAutoPlayInterval();
});




//インディケーター外枠
indicator.addEventListener('click', function(event) {
  if (!event.target.classList.contains('list')) return;
  const index = Array.from(lists).indexOf(event.target);
  //位置変更
  count = index + 2;
  slidePos();
  updateListBackground();
  //resetAutoPlayInterval();
});

//自動再生呼び出しファンクション
startAutoPlay();
