// マークダウンの基本設定
const markdown_setting = window.markdownit({
  html: true, // htmlタグを有効にする
  breaks: true, // md内の改行を<br>に変換
});

const markdown_editer = $(".js-markdown-editer");

// マークダウンの設定をjs-markdown-editerにHTMLとして反映させる
const markdown_html = markdown_setting.render(getHtml(markdown_editer));
markdown_editer.html(markdown_html);

const markdown_editer1 = $(".js-markdown-editer1");

// マークダウンの設定をjs-markdown-editerにHTMLとして反映させる
const markdown_html1 = markdown_setting.render(getHtml(markdown_editer1));
markdown_editer1.html(markdown_html1);

const markdown_editer2 = $(".js-markdown-editer2");

// マークダウンの設定をjs-markdown-editerにHTMLとして反映させる
const markdown_html2 = markdown_setting.render(getHtml(markdown_editer2));
markdown_editer2.html(markdown_html2);

  
// 比較演算子（=，<>，<，<=，>，>=）をそのまま置換する
function getHtml(selector) {
  let markdown_text = $(selector).html();
  // let markdown_text = document.querySelectorAll(selector)[1].innerHTML;
  markdown_text = markdown_text.replace(/&lt;/g, "<");
  markdown_text = markdown_text.replace(/&gt;/g, ">");
  markdown_text = markdown_text.replace(/&amp;/g, "&");

  return markdown_text;
}
