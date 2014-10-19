var LineChart,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

LineChart = (function() {
  function LineChart(containerId, data) {
    this.init = __bind(this.init, this);
    this.data = data || {};
    this.containerId = containerId;
    this.container = $('#' + this.containerId);
    this.context = this.container.get(0).getContext('2d');
    this.init();
    return this;
  }

  LineChart.prototype.init = function() {
    _.each(this.data.datasets, (function(_this) {
      return function(dataset, index) {
        return _this.data.datasets[index] = $.extend({
          'fillColor': "rgba(220,220,220,0.2)",
          'strokeColor': "rgba(220,220,220,1)",
          'pointColor': "rgba(220,220,220,1)",
          'pointStrokeColor': "#ccc",
          'pointHighlightFill': "#fff",
          'pointHighlightStroke': "rgba(220,220,220,1)"
        }, dataset);
      };
    })(this));
    this.chart = new Chart(this.context).Line(this.data, {});
    return this;
  };

  return LineChart;

})();
