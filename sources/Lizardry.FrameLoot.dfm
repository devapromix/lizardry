object FrameLoot: TFrameLoot
  Left = 0
  Top = 0
  Width = 709
  Height = 461
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object SG: TStringGrid
    Left = 0
    Top = 0
    Width = 709
    Height = 461
    Align = alClient
    ColCount = 2
    RowCount = 2
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRowSelect]
    ParentColor = True
    ScrollBars = ssVertical
    TabOrder = 0
    OnDblClick = SGDblClick
    ColWidths = (
      64
      64)
  end
end
