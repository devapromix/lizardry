object FrameTown: TFrameTown
  Left = 0
  Top = 0
  Width = 897
  Height = 474
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Panel7: TPanel
    Left = 616
    Top = 0
    Width = 281
    Height = 474
    Align = alRight
    BevelOuter = bvNone
    Color = clGreen
    ParentBackground = False
    TabOrder = 0
    object Panel8: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = 'CharName'
      ParentBackground = False
      TabOrder = 0
      object bbLogout: TSpeedButton
        Left = 192
        Top = 1
        Width = 88
        Height = 23
        Cursor = crHandPoint
        Align = alRight
        Caption = #1042#1099#1093#1086#1076
        Flat = True
        OnClick = SpeedButton1Click
        ExplicitTop = 0
      end
    end
    object Panel11: TPanel
      Tag = 4
      Left = 0
      Top = 25
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1059#1088#1086#1074#1077#1085#1100': 1'
      ParentBackground = False
      TabOrder = 1
    end
    object Panel12: TPanel
      Tag = 5
      Left = 0
      Top = 125
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1086#1083#1086#1090#1086' 100'
      ParentBackground = False
      TabOrder = 2
    end
    object Panel13: TPanel
      Tag = 5
      Left = 0
      Top = 50
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1054#1087#1099#1090': 0/100'
      ParentBackground = False
      TabOrder = 3
    end
    object Panel14: TPanel
      Tag = 5
      Left = 0
      Top = 75
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1047#1076#1086#1088#1086#1074#1100#1077': 30/30'
      ParentBackground = False
      TabOrder = 4
    end
    object Panel15: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 281
      Height = 25
      Align = alTop
      Alignment = taLeftJustify
      Caption = #1055#1088#1086#1074#1080#1079#1080#1103' 7/7'
      ParentBackground = False
      TabOrder = 5
    end
  end
  object Panel1: TPanel
    Left = 0
    Top = 0
    Width = 281
    Height = 474
    Align = alLeft
    BevelOuter = bvNone
    Color = clGreen
    ParentBackground = False
    TabOrder = 1
    object Panel2: TPanel
      Tag = 1
      Left = 0
      Top = 0
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 0
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel3: TPanel
      Tag = 2
      Left = 0
      Top = 25
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 1
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel4: TPanel
      Tag = 3
      Left = 0
      Top = 50
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 2
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel5: TPanel
      Tag = 4
      Left = 0
      Top = 75
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 3
      Visible = False
      OnClick = LeftPanelClick
    end
    object Panel6: TPanel
      Tag = 5
      Left = 0
      Top = 100
      Width = 281
      Height = 25
      Cursor = crHandPoint
      Align = alTop
      Alignment = taLeftJustify
      Caption = '111111'
      ParentBackground = False
      TabOrder = 4
      Visible = False
      OnClick = LeftPanelClick
    end
  end
  object Panel9: TPanel
    Left = 281
    Top = 0
    Width = 335
    Height = 474
    Align = alClient
    BevelOuter = bvNone
    TabOrder = 2
    object Panel10: TPanel
      Tag = 5
      Left = 0
      Top = 0
      Width = 335
      Height = 25
      Align = alTop
      Caption = 'Location name'
      ParentBackground = False
      TabOrder = 0
    end
    object StaticText1: TStaticText
      Left = 0
      Top = 25
      Width = 335
      Height = 125
      Align = alTop
      AutoSize = False
      Caption = 'Location description...'
      TabOrder = 1
    end
  end
end
