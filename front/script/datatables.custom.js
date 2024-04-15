$(function () {
    $.fn.dataTable.ext.buttons.reload = {
        text: 'Atualizar',
        action: function (e, dt, node, config) {
            location.reload();
        }
    };

    $.extend(true, $.fn.dataTable.defaults, {
        "order": [[0, "asc"]],
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, "All"]],
        "dom": 'lfritipB',
        buttons: {
            name: 'primary',
            buttons: ['copy', 'print', 'reload'],
        },
        language: {
            buttons: {
                copy: "Copiar para Excel",
                print: 'Imprimir',
                copyTitle: 'Copiado para Excel',
                copyKeys: 'Pressione <i> ctrl </ i> ou <i> \ u2318 </ i> + <i> C </ i> para copiar os dados da tabela para a área de transferência. <br> <br> Para cancelar, clique nesta mensagem ou pressione Esc.',
                copySuccess: {
                    _: '%d registros copiados',
                    1: '1 registro copiado'
                }
            },
            "emptyTable": "Nenhum dado disponível na tabela",
            "info": "Mostrando de _START_ à _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 de 0 a 0 entradas",
            "infoFiltered": "(filtrando de _MAX_ entradas totais)",
            "infoPostFix": "",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Busca Global:",
            "zeroRecords": "Nenhum registro correspondente encontrado!",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Próximo",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": ativar para classificar coluna ascendente",
                "sortDescending": ": ativar para classificar coluna descendente"
            },
            "decimal": ",",
            "thousands": "."
        }
    });

});

//filtra sem acentos
function accents_supr(data) {
    return !data ?
            '' :
            typeof data === 'string' ?
            data
            .replace(/\n/g, ' ')
            .replace(/[áàäâ]/g, 'a')
            .replace(/[éèëê]/g, 'e')
            .replace(/[íìïî]/g, 'i')
            .replace(/[óòöô]/g, 'o')
            .replace(/[úùüû]/g, 'u') :
            data;
    jQuery.extend(jQuery.fn.dataTableExt.oSort,
            {
                "brasil-string-asc": function (s1, s2) {
                    return s1.localeCompare(s2);
                },
                "brasil-string-desc": function (s1, s2) {
                    return s2.localeCompare(s1);
                }
            });
    jQuery.fn.DataTable.ext.type.search['brasil-string'] = function (data) {
        return accents_supr(data);
    }
}
;

//clear filters

