object FrameShop: TFrameShop
  Left = 0
  Top = 0
  Width = 910
  Height = 604
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
    Width = 910
    Height = 180
    Align = alTop
    Color = clBtnFace
    RowCount = 7
    Options = [goFixedVertLine, goFixedHorzLine, goVertLine, goHorzLine, goRowSelect]
    TabOrder = 0
    OnDblClick = SGDblClick
    OnKeyDown = SGKeyDown
  end
end
