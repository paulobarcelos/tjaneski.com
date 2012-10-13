// qs_score - Quicksilver Score
// 
// A port of the Quicksilver string ranking algorithm
// 
// "hello world".score("axl") //=> 0.0
// "hello world".score("ow") //=> 0.6
// "hello world".score("hello world") //=> 1.0
//
// Tested in Firefox 2 and Safari 3
//
// The Quicksilver code is available here
// http://code.google.com/p/blacktree-alchemy/
// http://blacktree-alchemy.googlecode.com/svn/trunk/Crucible/Code/NSString+BLTRRanking.m
//
// The MIT License
// 
// Copyright (c) 2008 Lachie Cox
// 
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
// 
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
// 
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.


String.prototype.score = function(abbreviation,offset) {
  offset = offset || 0 // TODO: I think this is unused... remove
 
  if(abbreviation.length == 0) return 0.9
  if(abbreviation.length > this.length) return 0.0

  for (var i = abbreviation.length; i > 0; i--) {
    var sub_abbreviation = abbreviation.substring(0,i)
    var index = this.indexOf(sub_abbreviation)


    if(index < 0) continue;
    if(index + abbreviation.length > this.length + offset) continue;

    var next_string       = this.substring(index+sub_abbreviation.length)
    var next_abbreviation = null

    if(i >= abbreviation.length)
      next_abbreviation = ''
    else
      next_abbreviation = abbreviation.substring(i)
 
    var remaining_score   = next_string.score(next_abbreviation,offset+index)
 
    if (remaining_score > 0) {
      var score = this.length-next_string.length;

      if(index != 0) {
        var j = 0;

        var c = this.charCodeAt(index-1)
        if(c==32 || c == 9) {
          for(var j=(index-2); j >= 0; j--) {
            c = this.charCodeAt(j)
            score -= ((c == 32 || c == 9) ? 1 : 0.15)
          }

          // XXX maybe not port this heuristic
          // 
          //          } else if ([[NSCharacterSet uppercaseLetterCharacterSet] characterIsMember:[self characterAtIndex:matchedRange.location]]) {
          //            for (j = matchedRange.location-1; j >= (int) searchRange.location; j--) {
          //              if ([[NSCharacterSet uppercaseLetterCharacterSet] characterIsMember:[self characterAtIndex:j]])
          //                score--;
          //              else
          //                score -= 0.15;
          //            }
        } else {
          score -= index
        }
      }
   
      score += remaining_score * next_string.length
      score /= this.length;
      return score
    }
  }
  return 0.0
}


// Original code from: http://ejohn.org/blog/jquery-livesearch/
// w/ slight modifications to allow full jquery expressions in the list

// USAGE:

// Add in the plugin with the following files:

//  <script type="text/javascript" src="jquery.liveupdate/quicksilver.js"></script>                            
//  <script type="text/javascript" src="jquery.liveupdate/jquery.liveupdate.js"></script>  

// $('#your-input').liveUpdate('#list-id')
// If you have html or anchors in your list, remember it only strips out the innerHTML of each jquery elem
// $('#your-input').liveUpdate('ul#list-id a')
// You don't have to restrict this to just lists, you can also filter table rows and such
// $('#your-input').liveUpdate('#tbl tr td')

jQuery.fn.liveUpdate = function(list){
  list = jQuery(list);
  if ( list.length ) {
      cache = list.map(function(){
        return this.innerHTML.toLowerCase();
      });
      
    this
      .keyup(filter).keyup();;
  }
    
  return this;
    
  function filter(){
    var term = jQuery.trim( jQuery(this).val().toLowerCase() ), scores = [];
    
    if ( !term ) {
      list.parents('tr').show();
    } else {
      list.parents('tr').hide();


      cache.each(function(i){
        var score = this.score(term);
        if (score > 0) { scores.push([score, i]); }
      });

      jQuery.each(scores.sort(function(a, b){return b[0] - a[0];}), function(){
        jQuery(list[ this[1] ]).parent().show();
      });
    }
  }
};




function attachments_update() {
	jQuery('div#attachments_file_list').html(attachments_media);
}

function init_attachments_sortable() {
	jQuery('div#attachments-list ul').sortable({
		containment: 'parent',
		stop: function(e, ui) {
			jQuery('#attachments-list ul li').each(function(i, id) {
				jQuery(this).find('input.attachment_order').val(i+1);
			});
		}
	});
}

jQuery(document).ready(function() {
	
	// If there are no attachments, let's hide this thing...
	if(jQuery('div#attachments-list li').length == 0) {
		jQuery('#attachments-list').hide();
	}
	else
	{
		init_attachments_sortable();
	}
		
	
	// Keep track of our browse dialog selections
	jQuery('.attachments a').live('click', function() {
		jQuery(this).toggleClass('attachments-selected');
		return false;
	});
	
	
	// Hook our delete links
	jQuery('span.attachment-delete a').live('click', function() {
		attachment_parent = jQuery(this).parent().parent().parent();
		attachment_parent.slideUp(function() {
			attachment_parent.remove();
			jQuery('#attachments-list ul li').each(function(i, id) {
				jQuery(this).find('input.attachment_order').val(i+1);
			});
			if(jQuery('div#attachments-list li').length == 0) {
				jQuery('#attachments-list').slideUp(function() {
					jQuery('#attachments-list').hide();
				});
			}
		});		
		return false;
	});
	
	
	// Hook the all important Apply button
	jQuery('a.attachments-apply').live('click', function() {
		attachment_index = jQuery('li.attachments-file').length;
		new_attachments = '';
		jQuery('a.attachments-selected').each(function() {
			
			attachment_name 		= jQuery(this).find('span.attachment-file-name').text();
			attachment_id			= jQuery(this).find('span.attachment-file-id').text();
			attachment_thumbnail	= jQuery(this).find('span.attachments-thumbnail').html();
			
			attachment_index++;
			new_attachments += '<li class="attachments-file">';
			new_attachments += '<h2><a href="#" class="attachment-handle"><span class="attachment-handle-icon"><img src="' + attachments_base + '/images/handle.gif" alt="Drag" /></span></a><span class="attachment-name">' + attachment_name + '</span><span class="attachment-delete"><a href="#">Delete</a></span></h2>';
			new_attachments += '<div class="attachments-fields">';
			new_attachments += '<div class="textfield" id="field_attachment_title_' + attachment_index + '"><label for="attachment_title_' + attachment_index + '">Title</label><input type="text" id="attachment_title_' + attachment_index + '" name="attachment_title_' + attachment_index + '" value="" size="20" /></div>';
			new_attachments += '<div class="textfield" id="field_attachment_caption_' + attachment_index + '"><label for="attachment_caption_' + attachment_index + '">Caption</label><input type="text" id="attachment_caption_' + attachment_index + '" name="attachment_caption_' + attachment_index + '" value="" size="20" /></div>';
			new_attachments += '</div>';
			new_attachments += '<div class="attachments-data">';
			new_attachments += '<input type="hidden" name="attachment_id_' + attachment_index + '" id="attachment_id_' + attachment_index + '" value="' + attachment_id + '" />';
			new_attachments += '<input type="hidden" class="attachment_order" name="attachment_order_' + attachment_index + '" id="attachment_order_' + attachment_index + '" value="' + attachment_index + '" />';
			new_attachments += '</div>';
			new_attachments += '<div class="attachment-thumbnail"><span class="attachments-thumbnail">';
			new_attachments += attachment_thumbnail;
			new_attachments += '</span></div>';
			new_attachments += '</li>';
		});
		jQuery('div#attachments-list ul').append(new_attachments);
		tb_remove();
		attachments_update();
		
		if(jQuery('#attachments-list li').length > 0) {

			// We've got some attachments
			jQuery('#attachments-list').show();

			// Cleanup
			jQuery('div#attachments-list ul').sortable('destroy');
			
			// Init sortable
			init_attachments_sortable();
			
		}
		
		return false;
		
	});
	
});