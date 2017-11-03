$(document).ready(function() {
	$('#blocksInOffer').sortable({
		cursor: 'move',
		start: function(event, ui) {
			$(ui.helper).addClass('draggingBlock');
		},
		beforeStop: function(event, ui) {
			$(ui.helper).removeClass('draggingBlock');
			$(ui.helper).removeAttr('style');
		}
	});
	$('#blocksInOffer').disableSelection();
	$('#blocksForYourChoice').disableSelection();
	$('.block').draggable({
		cursor: 'move',
		revert: 'invalid',
		opacity: 0.7,
		connectToSortable: '#blocksInOffer',
		stop: function(event, ui) {
			slyOfferMaker.updateSession();
			$(ui.helper).find('textarea').focus();
		}
	});
	$('#blocksForYourChoice .freeTextBlock').draggable({
		cursor: 'move',
		revert: 'invalid',
		opacity: 0.7,
		helper: 'clone',
		connectToSortable: '#blocksInOffer',
		start: function(event, ui) {
			$(ui.helper).addClass('draggingBlock');
		},
		stop: function(event, ui) {
			var pseudoId = slyOfferMaker.createNewPseudoId();
			$(ui.helper).attr('id', 'block-' + pseudoId);
			$(ui.helper).find('textarea').attr('id', 'block-' + pseudoId + '-text');
			$(ui.helper).find('.blockCreator input').attr('id', 'block-' + pseudoId + '-name');
			$(ui.helper).find('.blockCreator button').attr('id', 'block-' + pseudoId + '-insertButton');
			$(ui.helper).find('.blockUpdater button').attr('id', 'block-' + pseudoId + '-updateButton');
			$(ui.helper).find('.blockCreator button').click(function() {
				slyOfferMaker.insertBlock(pseudoId);
			});
			$(ui.helper).find('.blockRemover').click(function() {
				slyOfferMaker.removeBlock(pseudoId);
			});
			slyOfferMaker.updateSession();
			$(ui.helper).find('textarea').focus();
		}
	});
});

var slyOfferMaker = {
		
		getBlocks: function() {
			var blocks = Array();
			$('#blocksInOffer li').each(function() {
				var id = $(this).attr('id');
				if (id) {
					blocks.push({
						id: parseInt(id.replace(/^.*-([0-9]+)$/, '$1')),
						name: $(this).hasClass('freeTextBlock') ? 0 : $(this).find('.title').html(),
						text: $(this).find('textarea').val(),
						pseudo: $(this).hasClass('freeTextBlock') ? 1 : 0
					});
				}
			});
			return blocks;
		},
		
		updateSession: function() {
			$.post('./stepBlockeditor.php', {action:'updateSession', blocks:slyOfferMaker.getBlocks()});
		},
		
		createNewPseudoId: function() {
			var id = Math.ceil(Math.random() * 1000000);
			do {
				idAlreadyExists = false;
				$('.block, .freeTextBlock').each(function() {
					if ($(this).attr('id') && parseInt($(this).attr('id').replace(/^.*-([0-9]+)$/, '$1')) == id) {
						idAlreadyExists = true;
						return;
					}
				});
			} while(idAlreadyExists);
			return id;
		},
		
		removeBlock: function(id) {
			if ($('#block-' + id).hasClass('freeTextBlock')) {
				$('#block-' + id).remove();
			} else {
				$('#blocksForYourChoice').append($('#block-' + id));
				$('#block-' + id + ' .blockUpdater').removeAttr('style');
				$('#block-' + id).width('auto').height('auto');
			}
			slyOfferMaker.updateSession();
		},
		
		deleteBlock: function(id) {
			if (!confirm('Block wirklich ganz und f�r immer aus DB l�schen?')) return;
			$.post('./stepBlockeditor.php', {action:'deleteBlock', id:id}, function(res) {
				if (res == 1) {
					$('#block-' + id).remove();
					slyOfferMaker.updateSession();
				}
			});
		},
		
		insertBlock: function(pseudoId) {
			var text = $('#block-' + pseudoId + '-text').val();
			if (!text) {
				$('#block-' + pseudoId + '-text').effect('highlight', { color:'#efafaa'});
				$('#block-' + pseudoId + '-text').focus();
				return;
			}
			var name = $('#block-' + pseudoId + '-name').val();
			if (!name) {
				$('#block-' + pseudoId + '-name').effect('highlight', { color:'#efafaa'});
				$('#block-' + pseudoId + '-name').focus();
				return;
			}
			$('#block-' + pseudoId + '-insertButton').prop('disabled', true);
			$('#block-' + pseudoId + '-name').prop('disabled', true);
			$('#block-' + pseudoId + '-text').prop('disabled', true);
			$.post('./stepBlockeditor.php', {action:'insertBlock', name:name, text:text}, function(res) {
				if (res == 0) {
					$('#block-' + pseudoId + '-insertButton').html('Block in DB speichern');
					$('#block-' + pseudoId + '-name').effect('highlight', { color:'#efafaa'});
					$('#block-' + pseudoId + '-insertButton').prop('disabled', false);
					$('#block-' + pseudoId + '-text').prop('disabled', false);
					$('#block-' + pseudoId + '-name').prop('disabled', false);
					$('#block-' + pseudoId + '-name').focus();
					return;
				} else { //res = neue ID
					$('#block-' + pseudoId + '-insertButton').html('Block in DB gespeichert.');
					$('#block-' + pseudoId + '-text').attr('id', 'block-' + res + '-text');
					$('#block-' + pseudoId + '-name').attr('id', 'block-' + res + '-name');
					$('#block-' + pseudoId + '-insertButton').attr('id', 'block-' + res + '-insertButton');
					$('#block-' + pseudoId + '-updateButton').attr('id', 'block-' + res + '-updateButton');
					$('#block-' + pseudoId).attr('id', 'block-' + res);
				}
				setTimeout(function() {
					$('#block-' + res).removeClass('freeTextBlock').addClass('block');
					$('#block-' + res + ' .title').html(name);
					$('#block-' + res + ' .blockUpdater').prepend(name);
					$('#block-' + res + '-insertButton').html('Block in DB speichern');
					$('#block-' + res + ' .blockCreator').css('display', 'none');
					$('#block-' + res + ' .blockUpdater').css('display', 'block');
					$('#block-' + res + '-insertButton').prop('disabled', false);
					$('#block-' + res + '-text').prop('disabled', false);
					$('#block-' + res + '-name').prop('disabled', false);
					$('#block-' + res + ' .blockUpdater').click(function() {
						slyOfferMaker.updateBlock(res);
					});
					$('#block-' + res + ' .blockDeleter').click(function() {
						slyOfferMaker.deleteBlock(res);
					});
					$('#block-' + res + ' .blockRemover').click(function() {
						slyOfferMaker.removeBlock(res);
					});
					
					//bugfix: refresh draggable
					$('.block').draggable({
						cursor: 'move',
						revert: 'invalid',
						opacity: 0.7,
						connectToSortable: '#blocksInOffer',
						stop: function(event, ui) {
							slyOfferMaker.updateSession();
							$(ui.helper).find('textarea').focus();
						}
					});
					//----
					
					slyOfferMaker.updateSession();
					$('#block-' + res + '-text').focus();
				}, 1400);
			});
		},
		

		updateBlock: function(id) {
			$('#block-' + id + '-updateButton').prop('disabled', true);
			$('#block-' + id + '-text').prop('disabled', true);
			var text = $('#block-' + id + '-text').val();
			$.post('./stepBlockeditor.php', {action:'updateBlock', id:id, text:text}, function(res) {
				if (res == 1) {
					$('#block-' + id + '-updateButton').html('Block gespeichert.');
				} else {
					$('#block-' + id + '-updateButton').html('Keine �nderungen.');
				}
				setTimeout(function() {
					$('#block-' + id + '-updateButton').html('Block in DB speichern');
					$('#block-' + id + '-updateButton').prop('disabled', false);
					$('#block-' + id + '-text').prop('disabled', false);
					$('#block-' + id + '-text').focus();
				}, 1400);
				slyOfferMaker.updateSession();
			});
		}
};