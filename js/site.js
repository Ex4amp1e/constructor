id = 0;
function block(params = {}) {
    this.linked_blocks = [];
    this.id = (params.id != '') ? params.id : block_count;
    this.parent_id = params.parent_id;
    this.name = (params.name == undefined) ? 'Блок' : params.name;
    this.equipment_type = (params.eq_type != undefined) ? params.eq_type : 0;
    this.equipment_id = (params.eq_id != undefined) ? params.eq_id : 0;
    this.border_value = (params.border != undefined) ? params.border : '';
    this.productivity = (params.prod != undefined) ? params.prod : 0;
    this.return_level = (params.return_level != undefined) ? params.return_level : 0;
    this.eq_name = (params.eq_name != undefined) ? params.eq_name : 'Не выбрано';
    //this.equip_info = ((params.eq_id != undefined) ? params.eq_id : 'Название') + ((params.prod != undefined) ? params.prod : '');
    block_count = (params.id != '') ? (parseInt(params.id, 10)+1) : (block_count+1);
    //console.log(params.id == '');
    blocks[this.id] = this;
    
    this.selected = false;
    this.obj = $('<div></div>').addClass('block-item').on('click', $.proxy(function (event) {
        this.select({
            'load': true
        });
        event.stopPropagation();
    }, this));
    this.setEqType = function () {
        $('.equipment_type option[value="' + this.equipment_type + '"]').prop('selected', true);
        tools.loadEqNames({ 'type': this.equipment_type });
    }
    this.setEqId = function () {
        $('.equipment_name option[value="' + this.equipment_id + '"]').prop('selected', true);
        this.eq_name = $(".equipment_name option:selected").text();
    }
    this.obj[0].parent_block = this;
    this.line_top = $('<div></div>').addClass('block-linetop');
    this.line_gor = $('<div></div>').addClass('block-linegor');
    this.line_bot = $('<div></div>').addClass('block-linebot');
    this.container = $('<div></div>').addClass('block-container');
    this.right_back = $('<div></div>').addClass('right-back');
    this.arrow_back = $('<div></div>').addClass('arrow-back');
    this.bot_back = $('<div></div>').addClass('bot-back');
    this.equip_info = $('<div></div>').addClass('block-equip').html(this.eq_name + '-' + this.productivity + ' т/ч');
    this.border = $('<div class="block-text"></div>').addClass('block-border').html(this.border_value);
    if (this.eq_name!='Не выбрано') {
        this.equip_info.html(this.eq_name + '-' + this.productivity + ' т/ч');
    } else {
        this.equip_info.html(null);
    }
    this.header = $('<div></div>').addClass('block-header')
        .on('change blur', $.proxy(function (event) {
            this.name = $(event.target).closest('.block-header').find('input').val();
            //tools.resizeInput();
        }, this));
    this.input = $('<input type="text" value="' + this.name + '">').on('change keydown', function(event) {
        //$(event.target).attr('size', $(event.target).val().length);
        $(event.target).css('width', ($(event.target).val().length*0.63)+'em');
        tools.redrawBack();
        //console.log('!');
    });
    this.input.css('width', (this.name.length*0.63)+'em');
    this.select = function (params = {}) {
        if (selected_block !== null && selected_block != this.id) {
            blocks[selected_block].unselect();
        }
        this.selected = true;
        selected_block = this.id;
        this.obj.addClass('selected');
        tools.getSett({
            'block': this
        });
        if (params.load === true) {
            this.setEqType();
            //this.eq_name = $(".equipment_name option:selected").text();
        }
        $('.border_value').val(this.border_value);
        $('.productivity').val(this.productivity);
        $('.return_level').val(this.return_level);
    }
    this.unselect = function () {
        if (this.id == selected_block) {
            selected_block = null;
        }
        this.selected = false;
        this.obj.removeClass('selected');
    }
    this.del = function () {
        if (this.id == selected_block) {
            this.unselect();
            selected_block = null;
        }
        this.container.children('.block-item').each(function () {
            this.parent_block.del();
        });
        this.obj[0].remove(this.container[0]);
        this.obj[0].remove(this.header[0]);
        this.obj[0].remove(this.line_top[0]);
        this.obj[0].remove(this.line_gor[0]);
        //this.obj[0].remove(this.line_bot[0]);
        this.obj[0].remove(this.border[0]);
        this.obj[0].remove(this.right_back[0]);
        this.obj[0].remove(this.arrow_back[0]);
        //this.obj[0].remove(this.bot_back[0]);
        //this.obj[0].remove(this.prod[0]);
        //this.obj[0].remove(this.return_level[0]);
        this.parent.remove(this.obj[0]);
        delete (blocks[this.id]);
    }
    this.setBorder = function (params = {}) {
        if (params.border != undefined) {
            this.border_value = params.border;
            this.border.html(this.border_value);
        }
    }
    this.setEquipInfo = function (params = {}) {
        //var eq_name;
        //var prod_val;
        if (params.type == 'name') {
            this.eq_name = params.val;
            //console.log(params.type, params.val)
        }
        if (params.type == 'prod') {
            this.productivity = params.val;
        }
        if (this.eq_name!='Не выбрано') {
            this.equip_info.html(this.eq_name + '-' + this.productivity + ' т/ч');
        } else {
            this.equip_info.html(null);
        }
    }/*
    this.setProd = function (params = {}) {
        if (params.prod != undefined) {
            this.productivity = params.prod;
            this.equip_info.html(this.productivity);
            //this.prod.html(this.productivity);
        }
    }*/
    this.setReturn = function (params = {}) {
        if (params.return_level != undefined) {
            this.return_level = params.return_level;
            //this.equip_info.html(this.params.return_level);
        }
    }
    if (params.parent != undefined) {
        this.parent = $(params.parent);
        this.parent.append(this.obj);
        this.obj.append(this.header);
        this.obj.append(this.line_top);
        this.obj.append(this.line_gor);
        this.header.append(this.input);
        this.header.append(this.line_bot);
        this.header.append(this.bot_back);
        this.header.append(this.equip_info);
        this.obj.append(this.container);
        //this.container.append(this.line_bot);  
        this.obj.append(this.border);
        //this.obj.append(this.prod);
        this.obj.append(this.right_back);
        this.obj.append(this.arrow_back);
        //this.obj.append(this.return_level);
    }
    tools.redrawBack();
    return this;
}

tools = {/*
    resizeInput: function (params = {}) {
        for (key in blocks) {
            blocks[key].input.attr('size', blocks[key].name.length);
        }
        //$(this).attr('size', $(this).val().length);
    },*/
    redrawBack: function (params = {}) {
        for (key in blocks) {
            blocks[key].linked_blocks = [];
            blocks[key].right_back.removeClass("visible");
            blocks[key].arrow_back.removeClass("visible");
            blocks[key].bot_back.removeClass("visible");
        }
        for (key in blocks) {
            if (blocks[key].return_level != 0) {
                let k = blocks[key].return_level - 1;
                let o = blocks[key].parent_id;
                while (k > 0 && blocks[o].parent_id != undefined) {
                    o = blocks[o].parent_id;
                    k--;
                }

                if (k == 0) {
                    blocks[o].linked_blocks.push(blocks[key]);
                } else {
                    let lvl = blocks[key].return_level - k;
                    alert('Ошибка: для данного блока максимальный уровень возврата равен ' + lvl);
                    blocks[key].return_level = lvl;
                    $('.return_level').val(lvl);
                    tools.redrawBack();
                }
            }
        }
        for (key in blocks) {
            // console.log(blocks); //.header.offset().top,blocks[2].header.offset().top
            if (blocks[key].linked_blocks.length > 0) {
                maxh = 0;
                maxw = 0;
                let h1 = blocks[key].header.offset().top;
                let w1 = (blocks[key].obj.innerWidth() - blocks[key].header.width()) / 2 - 28;
                for (key2 in blocks[key].linked_blocks) {
                    let parent_w = blocks[key].obj.outerWidth();
                    let head_offset = blocks[key].linked_blocks[key2].header.offset().left;
                    let parent_offset = blocks[key].obj.offset().left;
                    let head_w = blocks[key].linked_blocks[key2].header.outerWidth();
                    //w2 = parent_w - head_offset + parent_offset - head_w - 7; работало
                    w2 = parent_w - head_offset + parent_offset - head_w / 2 - 7;
                    //arrow_left = (blocks[key].linked_blocks[key2].obj.outerWidth() + head_w)/2; работало
                    arrow_left = blocks[key].linked_blocks[key2].obj.outerWidth() / 2;
                    if (blocks[key].linked_blocks[key2].eq_name!='Не выбрано') {
                        arrow_back_top = 110;
                    } else {
                        arrow_back_top = 86;
                    }
                    blocks[key].linked_blocks[key2].arrow_back.addClass("visible").width(w2).css("left", arrow_left + "px").css("top",arrow_back_top + "px");
                    blocks[key].linked_blocks[key2].bot_back.addClass("visible");
                    let h2 = blocks[key].linked_blocks[key2].header.offset().top;
                    if (h2 - h1 > maxh) {
                        delta = 0;
                        if (blocks[key].linked_blocks[key2].eq_name!='Не выбрано') {
                            delta = 25;
                        }
                        maxh = h2 - h1;
                    }
                }
                blocks[key].right_back.addClass("visible").height(maxh + 50 + delta).width(w1);
            }
        }
    },
    addBlock: function (params = {}) {
        let error = false;
        let msg = '';
        let name = params.name;
        if (selected_block === null) {
            if (root.children().length > 0) {
                error = true;
                msg = 'Ошибка: уже создан блок 1 уровня';
            } else {
                parent = root;
                console.log(name);
                if (params.name == undefined) {
                    name = 'Добыча руды';
                }
            }
        } else {
            if (blocks[selected_block].return_level > 0) {
                error = true;
                msg = 'Ошибка: уровень возврата > 0';
            } else {
                parent = blocks[selected_block].container;
                blocks[selected_block].header.addClass('children-exist');
            }
        }
        if (!error) {
            return new block({
                'id': params.id,
                'name': name,
                'parent': parent,
                'parent_id': selected_block,
                'eq_type': params.eq_type,
                'eq_id': params.eq_id,
                'border': params.border,
                'prod': params.prod,
                'return_level': params.return_level,
                'eq_name' : params.eq_name,
            });
        } else {
            alert(msg);
        }
    },
    delBlock: function (params = {}) {
        if (selected_block !== null) {
            if (blocks[selected_block].parent.children('.block-item').length == 1 && blocks[blocks[selected_block].parent_id] !== undefined) {
                blocks[blocks[selected_block].parent_id].header.removeClass('children-exist');
            }
            blocks[selected_block].del();
        } else {
            alert('Ошибка: не выбран блок');
        }
        tools.redrawBack();
    },
    clearSxem() {
        first_block = root.children('.block-item');
        if (first_block.length > 0) {
            first_block[0].parent_block.select();
            tools.delBlock();
        }
        block_count = 0;
        selected_block = null;

    },
    makeSxem: function (params = {}) {
        if (params.parent == -1) {
            tools.clearSxem();
        }
        for (key in params.blocks) {
            if (params.blocks[key].parent >= 0) {
                blocks[params.blocks[key].parent].select();
            }
            let added_block = tools.addBlock({
                'id': params.blocks[key].id,
                'name': params.blocks[key].name,
                'eq_type': params.blocks[key].eq_type,
                'eq_id': params.blocks[key].eq_id,
                'border': params.blocks[key].border,
                'prod': params.blocks[key].prod,
                'return_level': params.blocks[key].return_level,
                'eq_name' : params.blocks[key].eq_name,
            });
            //blocks[params.blocks[key].parent].unselect();
        }
        /*
                for (key in params.blocks) {
                    if (params.parent == params.blocks[key].parent) {
                        if (params.parent_obj != undefined) {
                            params.parent_obj.select();
                        }
                        let added_block = tools.addBlock({
                            'id': params.id,
                            'name': params.blocks[key].name,
                            'eq_type': params.blocks[key].eq_type,
                            'eq_id': params.blocks[key].eq_id,
                            'border': params.blocks[key].border,
                            'prod': params.blocks[key].prod,
                            'return_level': params.blocks[key].return_level
                        });
                        added_block.select();
                        tools.makeSxem({
                            'id': params.id,
                            'blocks': params.blocks,
                            'parent': key,
                            'parent_obj': added_block
                        });
                    }
                }*/
    },
    makeData: function (params = {}) {
        data = {};
        for (key in blocks) {
            parent_id = (blocks[key].parent_id === null) ? -1 : blocks[key].parent_id;
            data[key] = {
                'id': key,
                'name': blocks[key].name,
                'parent': parent_id,
                'eq_type': blocks[key].equipment_type,
                'eq_id': blocks[key].equipment_id,
                'border': blocks[key].border_value,
                'prod': blocks[key].productivity,
                'return_level': blocks[key].return_level,
            };
        }
        $.ajax({
            type: 'POST',
            //url: 'put.php',
            url: '?p=engine/put',
            data: {
                'id': params.id,
                'name': $('.schema-name').text(),
                'data_block': data
            },
            success: function (msg) {
                if (msg.schema_id > 0) {
                    window.location.href = "?p=schema&id=" + msg.schema_id;
                }
                alert(msg.message);
            }
        });
    },
    delSchema: function (params = {}) {
        var result = confirm("Удалить?");
        if (result) {
            $.ajax({
                type: 'POST',
                url: '?p=engine/delete',
                //url: '/engine/delete.php',
                data: {
                    'id': params.id,
                    'token': params.token
                },
                success: function (msg) {
                    alert(msg.message);
                    if (msg.success) {
                        window.location.href = "?p=list";
                    }

                }
            });
        }
    },
    getSett: function (params = {}) {
        $('.settings h2').text(params.block.name);
    },
    loadEqTypes: function (params = {}) {
        $.ajax({
            //url: "equip_type.php",
            url: "?p=engine/equip_type",
            success: function (msg) {
                if (msg.eq_types != undefined) {
                    eq_types_obj = $('.equipment_type');
                    eq_names_obj = $('.equipment_name');
                    eq_types_obj.find('option[value!=0]').remove();
                    $(msg.eq_types).each(function () {
                        eq_types_obj.append('<option value="' + this.id + '">' + this.name + '</option>');
                    });

                    eq_types_obj.on('change', function () {
                        tools.loadEqNames({ 'type': this.value });
                        if (selected_block !== null) {
                            blocks[selected_block].equipment_type = this.value;
                            blocks[selected_block].equipment_id = 0;
                            blocks[selected_block].setEquipInfo({
                                'type' : 'name',
                                'val'  : 'Не выбрано'
                            });
                        }
                        tools.redrawBack();
                    });
                    eq_names_obj.on('change', function () {
                        if (selected_block !== null) {
                            blocks[selected_block].equipment_id = this.value;
                            blocks[selected_block].setEquipInfo({
                                'type' : 'name',
                                'val'  : $(".equipment_name option:selected").text()
                            });
                        }
                        tools.redrawBack();
                    });
                }
            }
        });
    },
    loadEqNames: function (params = {}) {
        $.ajax({
            url: "?p=engine/equip_names",
            type: 'POST',
            data: {
                'eq_type': params.type
            },
            success: function (msg) {
                if (msg.eq_names != undefined) {
                    eq_names_obj = $('.equipment_name');
                    eq_names_obj.find('option[value!=0]').remove();
                    $(msg.eq_names).each(function () {
                        eq_names_obj.append('<option value="' + this.id + '">' + this.name + '</option>');
                    });
                    if (selected_block !== null) {
                        blocks[selected_block].setEqId({});
                    }
                }
            }
        });

    }
}

var root;
var blocks = {};
var block_count = 0;
var selected_block = null;

function getData(params = {}) {
    $.ajax({
        type: "POST",
        url: "?p=engine/data",
        data: params,
        success: function (msg) {
            if (msg.blocks != undefined) {
                tools.makeSxem({ 'id': params.id, 'blocks': msg.blocks, 'parent': -1 });
            }
            if (selected_block != null) {
                blocks[selected_block].select({
                    'load': true
                });
            }
        }
    });
}

$(document).ready(function () {
    root = $('.shema');
    //tools.loadEqTypes();
    //getData();
    $(".shema").on("click", function () {
        if (selected_block !== null) {
            blocks[selected_block].unselect();
        }
    });
    $(".schema-name").on("click", function () {
        $(this).closest("h1").addClass("name-edit").children(".schema-name-input").focus().select();
    });
    $(".schema-name-input").on("blur", function () {
        if ($(this).val() != '') {
            $(this).closest("h1").removeClass("name-edit").children(".schema-name").text($(this).val());
        } else $(this).closest("h1").removeClass("name-edit").children(".schema-name").text('Введите название');
    });
    $('.border_value').on('keyup', function () {
        if (selected_block != null) {
            blocks[selected_block].setBorder({
                'border': this.value
            });
        }
    });
    $('.productivity').on('keyup', function () {
        if (selected_block != null) {
            blocks[selected_block].setEquipInfo({
                'type' : 'prod',
                'val'  : this.value
            });
        }
    });
    $('.return_level').on('change', function () {
        if (selected_block != null) {
            if (blocks[selected_block].container.children(".block-item").length == 0) {
                blocks[selected_block].setReturn({
                    'return_level': this.value
                });
                tools.redrawBack();
            } else {
                alert('Ошибка: у блока имеются потомки');
                $('.return_level').val('0');
            }
        }
    });
});