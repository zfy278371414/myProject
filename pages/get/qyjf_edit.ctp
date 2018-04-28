<template>
  <div class="page hangqinPub">
     <div class="navbar">
        <div class="navbar-inner">
            <div class="left">
            </div>
            <div class=" title sliding"><p>自选</p></div>
            <div class="right">
              <p>完成</p>
            </div>
        </div>
      </div>
    <div class="page-content editPage">
        <div class='edit-title'>
          <p>名称</p>
          <p>置顶</p>
          <p>拖动</p>
        </div>
        <div class=' list sortable sortable-enabled'>
        <ul>
          <li style='position:relative'>
            <div>
                <img class='imgDelete'src='img/qyjf/delete.png'>
                <div>
                  <p>招商证券1</p>
                  <p class='stockCode'>399011</p>
                </div>
              </div>
              <div>
                <img class='imgZhiding' src='img/qyjf/zhiding.png'>
              </div>
              <!-- <div>
                <img class='imgDrag' src='img/qyjf/drag.png'>
              </div> -->
              <div class='sortable-handler'></div>
          </li>
          <li style='position:relative'>
            <div>
                <img class='imgDelete'src='img/qyjf/delete.png'>
                <div>
                  <p>招商证券2</p>
                  <p class='stockCode'>399011</p>
                </div>
              </div>
              <div>
                <img class='imgZhiding' src='img/qyjf/zhiding.png'>
              </div>
              <!-- <div>
                <img class='imgDrag' src='img/qyjf/drag.png'>
              </div> -->
              <div class='sortable-handler'></div>
          </li>
          <li style='position:relative'>
            <div>
                <img class='imgDelete'src='img/qyjf/delete.png'>
                <div>
                  <p>招商证券3</p>
                  <p class='stockCode'>399011</p>
                </div>
              </div>
              <div>
                <img class='imgZhiding' src='img/qyjf/zhiding.png'>
              </div>
              <!-- <div>
                <img class='imgDrag' src='img/qyjf/drag.png'>
              </div> -->
              <div class='sortable-handler'></div>
          </li>
          <li style='position:relative'>
            <div>
                <img class='imgDelete'src='img/qyjf/delete.png'>
                <div>
                  <p>招商证券4</p>
                  <p class='stockCode'>399011</p>
                </div>
              </div>
              <div>
                <img class='imgZhiding' src='img/qyjf/zhiding.png'>
              </div>
              <!-- <div>
                <img class='imgDrag' src='img/qyjf/drag.png'>
              </div> -->
              <div class='sortable-handler'></div>
          </li>
          <li style='position:relative'>
            <div>
                <img class='imgDelete'src='img/qyjf/delete.png'>
                <div>
                  <p>招商证券5</p>
                  <p class='stockCode'>399011</p>
                </div>
              </div>
              <div>
                <img class='imgZhiding' src='img/qyjf/zhiding.png'>
              </div>
              <!-- <div>
                <img class='imgDrag' src='img/qyjf/drag.png'>
              </div> -->
              <div class='sortable-handler'></div>
          </li>
          
        </ul>
        </div>
        
    </div>
  </div>
</template>
<script>
return {
  on: {
    pageInit: function() {
      app.on('sortableSort',function(listEl,indexes){
        console.log(11111111111111111)
      })
    }
  }
}

</script>
