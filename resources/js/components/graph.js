import cytoscape from 'cytoscape';

const severityLabels = {
    minor: 'Leve',
    moderate: 'Moderada',
    major: 'Grave',
    contraindicated: 'Contraindicada'
};

class GraphViewer {

    constructor(element) {

        this.element = element;

        this.canvas = element.querySelector('[data-graph-canvas]');

        this.elements = JSON.parse(
            element.dataset.graphElements
        );

        this.preview = element.dataset.graphPreview === 'true';

        this.details = Array.from(
            document.querySelectorAll('[data-graph-details]')
        ).find(panel =>
            panel.dataset.graphDetails === this.canvas.id
        )?.querySelector('[data-graph-details-content]');

        this.emptyDetails = this.details?.innerHTML;

        this.cy = this.initialize();

        this.bindControls();
        this.bindEvents();

    }

    initialize() {

        return cytoscape({

            container: this.canvas,

            elements: this.elements,

            style: this.getStyles(),

            layout: {
                name: 'cose',

                animate: false,
                randomize: true,

                padding: 60,

                nodeDimensionsIncludeLabels: true,

                idealEdgeLength: 200,
                nodeRepulsion: 16000,
                nodeOverlap: 40,
                edgeElasticity: 100,

                componentSpacing: 150,
                gravity: 0.15,

                numIter: 2500
            },

            minZoom: 0.1,
            maxZoom: 4,

            autoungrabify: this.preview,
            autounselectify: this.preview,

            userZoomingEnabled: !this.preview,
            userPanningEnabled: !this.preview,

            boxSelectionEnabled: false,
            selectionType: 'single'

        });

    }

    getStyles() {

        const css = getComputedStyle(this.element);

        const color = name =>
            css.getPropertyValue(name).trim();

        const maxDegree = this.elements.nodes.reduce(
            (max, node) => Math.max(max, node.data.degree),
            1
        );

        const nodeSize = node =>
            28 + 24 * (node.data('degree') / maxDegree);

        return [

            {
                selector: 'node',

                style: {
                    'background-color': color('--color-primary'),

                    'width': nodeSize,
                    'height': nodeSize,

                    'label': 'data(name)',

                    'font-family': 'Inter, sans-serif',
                    'font-size': 11,
                    'color': color('--color-heading'),

                    'text-valign': 'bottom',
                    'text-halign': 'center',
                    'text-margin-y': 10,

                    'text-wrap': 'wrap',
                    'text-max-width': 90,

                    'text-background-color': color('--color-background'),
                    'text-background-opacity': 0.9,
                    'text-background-padding': 3,
                    'text-background-shape': 'roundrectangle',

                    'border-width': 2,
                    'border-color': color('--color-white')
                }
            },

            {
                selector: 'edge',

                style: {
                    'width': 2.5,
                    'curve-style': 'straight',
                    'line-color': color('--color-border-strong')
                }
            },

            ...Object.keys(severityLabels).map(severity => ({

                selector: `edge[severity = "${severity}"]`,

                style: {
                    'line-color': color(
                        `--color-severity-${severity}`
                    )
                }

            })),

            {
                selector: 'node:selected',

                style: {
                    'border-width': 4,
                    'border-color': color('--color-primary-light')
                }
            },

            {
                selector: 'edge:selected',

                style: {
                    'width': 5
                }
            },

            {
                selector: '.faded',

                style: {
                    'opacity': 0.15
                }
            }

        ];

    }

    bindControls() {

        const controls = [
            ['[data-graph-zoom-in]', () => this.zoom(1.25)],
            ['[data-graph-zoom-out]', () => this.zoom(0.8)],
            ['[data-graph-fit]', () => this.fit()]
        ];

        controls.forEach(([selector, callback]) => {

            const button = this.element.querySelector(selector);

            if (!button) {
                return;
            }

            button.disabled = false;

            button.addEventListener('click', callback);

        });

    }

    zoom(factor) {

        this.cy.zoom({

            level: this.cy.zoom() * factor,

            renderedPosition: {
                x: this.cy.width() / 2,
                y: this.cy.height() / 2
            }

        });

    }

    fit() {

        this.cy.fit(this.cy.elements(), 40);

    }

    bindEvents() {

        if (this.preview) {
            return;
        }

        this.cy.on('select', 'node, edge', event => {

            const element = event.target;

            this.highlight(element);
            this.renderDetails(element);

        });

        this.cy.on('unselect', 'node, edge', () => {

            const selected = this.cy.$(':selected');

            if (selected.length > 0) {
                this.highlight(selected.first());
                this.renderDetails(selected.first());
            } else {
                this.clearSelection();
            }

        });

        this.cy.on('tap', event => {

            if (event.target === this.cy) {

                this.cy.$(':selected').unselect();

                this.clearSelection();

            }

        });

    }

    highlight(element) {

        let visible;

        if (element.isNode()) {

            visible = element.closedNeighborhood();

        } else {

            visible = element.union(
                element.connectedNodes()
            );

        }

        this.cy.elements().removeClass('faded');

        this.cy.elements()
            .difference(visible)
            .addClass('faded');

    }

    clearSelection() {

        this.cy.elements().removeClass('faded');

        if (this.details) {
            this.details.innerHTML = this.emptyDetails;
        }

    }

    renderDetails(element) {

        if (!this.details) {
            return;
        }

        const data = element.data();

        this.details.replaceChildren();

        const container = document.createElement('div');
        container.className = 'stack';

        const fields = document.createElement('dl');
        fields.className = 'detail-list detail-list--2';

        if (element.isNode()) {

            this.addField(fields, 'Medicamento', data.name);

            this.addField(
                fields,
                'Classificação',
                data.classification
            );

            this.addField(fields, 'Grau', data.degree);

            this.addField(
                fields,
                'Descrição',
                data.description,
                true
            );

        } else {

            this.addField(
                fields,
                'Medicamento A',
                element.source().data('name')
            );

            this.addField(
                fields,
                'Medicamento B',
                element.target().data('name')
            );

            this.addField(
                fields,
                'Severidade',
                severityLabels[data.severity]
            );

            this.addField(
                fields,
                'Descrição',
                data.description,
                true
            );

        }

        container.append(fields);

        if (data.url) {

            const link = document.createElement('a');

            link.href = data.url;

            link.textContent = element.isNode()
                ? 'Visualizar medicamento'
                : 'Visualizar interação';

            link.className = 'button button--secondary';

            const actions = document.createElement('div');

            actions.className = 'cluster';

            actions.append(link);
            container.append(actions);

        }

        this.details.append(container);

    }

    addField(container, label, value, full = false) {

        const field = document.createElement('div');

        field.className = full
            ? 'detail-item detail-item--full'
            : 'detail-item';

        const term = document.createElement('dt');

        term.textContent = label;

        const description = document.createElement('dd');

        description.textContent = value ?? 'Não informado';

        field.append(term, description);

        container.append(field);

    }

}

document.querySelectorAll('[data-graph]').forEach(element => {

    new GraphViewer(element);

});
