function checkOverflow(slideNavigateID, listID)
{
  const el = document.getElementById(listID);
  const curOverflow = el.style.overflow;

  if (!curOverflow || curOverflow === "visible")
    el.style.overflow = "hidden";

  const isOverflowing = el.clientWidth < el.scrollWidth
    || el.clientHeight < el.scrollHeight;

  el.style.overflow = curOverflow;
  if (isOverflowing)
  {
    if (window.innerWidth >= 992)
      document.getElementById(slideNavigateID).style.display = 'flex';
    else
      document.getElementById(slideNavigateID).style.display = 'none';
  }
  else
  {
    document.getElementById(slideNavigateID).style.display = 'none';
  }
}

function addScrollEvent(navigateLeftID, navigateRightID, listID)
{
  document.getElementById(navigateRightID).addEventListener('click', function ()
  {
    document.getElementById(listID).scrollLeft += 500;
  });

  document.getElementById(navigateLeftID).addEventListener('click', function ()
  {
    document.getElementById(listID).scrollLeft -= 500;
  });
}

function showHoveredBook(index)
{
  document.querySelectorAll(`div[name="bestSellerDetail"]:not(#bestSellerDetail_${ index })`).forEach(function (div)
  {
    div.style.display = 'none';
  });

  document.querySelector('#bestSellerDetail_' + index).style.display = 'block';
}